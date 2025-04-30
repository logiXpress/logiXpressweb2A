import dash
from dash import dcc, html
import plotly.graph_objects as go
import pandas as pd
import numpy as np
from datetime import datetime
from sqlalchemy import create_engine
from sklearn.linear_model import LinearRegression
import matplotlib.pyplot as plt

# Create an SQLAlchemy engine for MySQL
db_connection_str = 'mysql+mysqlconnector://root:@localhost:3306/db'  # Update with your DB info
db_engine = create_engine(db_connection_str)

# Fetch data from the 'livraisons' table
query = "SELECT Date_creation, Montant FROM livraisons"
df = pd.read_sql(query, db_engine)

# Ensure the date is in the right format
df['Date_creation'] = pd.to_datetime(df['Date_creation'])

# Sort data by Date_creation to ensure it's in chronological order
df = df.sort_values('Date_creation')

# Get the current date
current_date = datetime.now()

# Split the data into past and future data based on the current date
past_data = df[df['Date_creation'] <= current_date]
future_dates = pd.date_range(start=current_date, periods=5, freq='D')  # Adjust periods as needed

# Prepare the data for linear regression
# We'll use the index as the X values for regression (time series modeling)
X = np.array(range(len(past_data))).reshape(-1, 1)
y = past_data['Montant'].values

# Train the linear regression model
model = LinearRegression()
model.fit(X, y)

# Predict future values
future_X = np.array(range(len(past_data), len(past_data) + len(future_dates))).reshape(-1, 1)
predicted_values = model.predict(future_X)

# Combine both past and predicted data
predicted_df = pd.DataFrame({
    'Date_creation': future_dates,
    'Montant': predicted_values
})

# Create Dash application
app = dash.Dash(__name__)

# Create the Plotly figure
fig = go.Figure()

# Plot past data with blue color
fig.add_trace(go.Scatter(x=past_data['Date_creation'], y=past_data['Montant'],
                         mode='lines+markers', name='Past Livraisons', marker=dict(color='blue')))

# Plot future/predicted data with red color
fig.add_trace(go.Scatter(x=predicted_df['Date_creation'], y=predicted_df['Montant'],
                         mode='lines+markers', name='Predicted Livraisons', marker=dict(color='red')))

# Update layout for the figure
fig.update_layout(
    title="Livraisons Over Time",
    xaxis_title="Date",
    yaxis_title="Montant",
    template='plotly_dark',  # Change this template for different styles
)

# Define the layout for the Dash app
app.layout = html.Div(children=[
    html.H1(children=""),
    
    dcc.Graph(
        id='livraison-graph',
        figure=fig
    ),
    
    html.Button("Quit", id="quit-button", n_clicks=0),
])

# Run the Dash app
if __name__ == '__main__':
    app.run(debug=True)
