import dash
from dash import dcc, html
from dash.dependencies import Input, Output
import plotly.graph_objects as go
import pandas as pd
from datetime import datetime
from sklearn.linear_model import LinearRegression
from sklearn.preprocessing import StandardScaler
import mysql.connector

# Format amount function (Rescale values by dividing by 1000 for 'K' format)
def format_amount(montant):
    if montant >= 1_000_000:
        return f"{montant / 1_000_000:.2f} M"
    elif montant >= 1_000:
        return f"{montant / 1_000:.2f} K"
    else:
        return f"{montant:,.2f}"

# CashflowPredictor class (same as before)
class CashflowPredictor:
    def __init__(self, db_config):
        self.db_config = db_config
        self.model = LinearRegression()
        self.scaler = StandardScaler()

        # Initially load the data
        self.load_data()

        # Nettoyer : supprimer les lignes où 'Montant' est vide
        self.data = self.data.dropna(subset=['Montant'])

        # Vérification si on a des données après nettoyage
        if self.data.empty:
            raise ValueError("Pas de données valides pour entraîner le modèle. Vérifiez votre base de données.")

        # Entraînement du modèle
        X = self.data[['timestamp']]
        y = self.data['Montant']
        X_scaled = self.scaler.fit_transform(X)
        self.model.fit(X_scaled, y)

    def create_connection(self):
        conn = mysql.connector.connect(
            host=self.db_config['host'],
            user=self.db_config['user'],
            password=self.db_config['password'],
            database=self.db_config['database']
        )
        return conn

    def load_data(self):
        # Load fresh data from the database
        conn = self.create_connection()
        query = "SELECT Date_creation, Montant, UNIX_TIMESTAMP(Date_creation) AS timestamp FROM livraisons"
        self.data = pd.read_sql(query, conn)
        conn.close()

    def predict_payment(self, target_date):
        target_timestamp = pd.to_datetime(target_date).timestamp()
        target_scaled = self.scaler.transform([[target_timestamp]])
        predicted_payment = self.model.predict(target_scaled)
        return predicted_payment[0]

# Example DB config
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'db'
}

# Initialize the predictor
predictor = CashflowPredictor(db_config)

# Create Dash application
app = dash.Dash(__name__)

# Create the initial Plotly figure with data
def create_figure():
    # Load data from DB
    predictor.load_data()

    # Rescale the 'Montant' values by dividing by 1000 (to show in thousands)
    df = predictor.data
    df['Montant_rescaled'] = df['Montant'] / 1000

    # Separate past data
    past_data = df[df['Date_creation'] <= datetime.now()]

    # Example: Get predictions for the next 5 days
    future_dates = pd.date_range(start=datetime.now(), periods=5, freq='D')
    predicted_values = [predictor.predict_payment(date) for date in future_dates]

    # Rescale predicted future values by 1000
    predicted_values_rescaled = [value / 1000 for value in predicted_values]

    # Create the Plotly figure
    fig = go.Figure()

    # Plot past data with blue color
    fig.add_trace(go.Scatter(x=past_data['Date_creation'], y=past_data['Montant_rescaled'],
                             mode='lines+markers', name='Past Livraisons', marker=dict(color='blue')))

    # Plot future/predicted data with red color
    fig.add_trace(go.Scatter(x=future_dates, y=predicted_values_rescaled,
                             mode='lines+markers', name='Predicted Livraisons', marker=dict(color='red')))

    # Format y-axis tick labels
    fig.update_layout(
        title="Livraisons Over Time",
        xaxis_title="Date",
        yaxis_title="Montant (in K)",
        template='plotly_dark',
        yaxis=dict(
            tickmode='array',
            tickvals=[0, 10, 50, 100, 500],  # Example ticks for formatting (scaled by 1000)
            ticktext=[format_amount(0), format_amount(1000), format_amount(5000), format_amount(10000), format_amount(50000)]  # Corresponding labels
        )
    )
    return fig

# Define the layout for the Dash app
app.layout = html.Div(children=[
    html.H1(children="Livraisons Data Visualization"),
    
    dcc.Graph(
        id='livraison-graph',
        figure=create_figure()
    ),
    
    html.Button("Update Data", id="update-button", n_clicks=0),
])

# Define callback to update the figure when the button is clicked
@app.callback(
    Output('livraison-graph', 'figure'),
    [Input('update-button', 'n_clicks')]
)
def update_data(n_clicks):
    if n_clicks > 0:
        # Reload the data and update the figure
        return create_figure()
    return create_figure()

# Run the Dash app
if __name__ == '__main__':
    app.run(debug=True)
