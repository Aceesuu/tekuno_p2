import pandas as pd
from sqlalchemy import create_engine, Integer, Float, VARCHAR
from datetime import datetime, timedelta
import numpy as np

# Replace 'your_database_uri' with the actual URI to your MySQL database
database_uri = 'mysql+mysqlconnector://root:@localhost/tekuno_p2'
engine = create_engine(database_uri)

# Replace the SQL query with your dynamic query
query = """
    SELECT
        YEAR(order_date) AS year,
        MONTHNAME(order_date) AS month,
        SUM(price) AS monthly_sales
    FROM (
        SELECT order_date, price
        FROM tb_order
        WHERE order_status = 'Complete'
        UNION ALL
        SELECT order_date, price
        FROM order_onsite
    ) AS combined_data
    GROUP BY year, month
    ORDER BY year, month
"""

# Fetch data from the database
df = pd.read_sql(query, engine)

# Convert month names to numeric values
month_order = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
df["month_numeric"] = df["month"].apply(lambda x: month_order.index(x) + 1)

# Calculate moving average
window_size = 3  # You can adjust this based on your needs
df["moving_average"] = df["monthly_sales"].rolling(window=window_size).mean()

# Print the DataFrame with moving averages
print(df)

# Get the current date
today = datetime.now()

# Create a DataFrame for predicted data
predicted_data = []

# Predict monthly sales and moving average for the next 5 months
for i in range(5):
    next_month_date = today + timedelta(days=30 * (i + 1))
    next_month_name = next_month_date.strftime("%B")

    # Replace the following lines with your actual prediction logic
    predicted_sales = np.random.randint(800, 1200)  # Replace with your prediction logic
    predicted_average = np.random.randint(700, 1100)  # Replace with your prediction logic

    predicted_data.append({
        "year": next_month_date.year,
        "month": next_month_name,
        "monthly_sales": predicted_sales,
        "moving_average": predicted_average
    })

# Create a DataFrame from the predicted data
predicted_df = pd.DataFrame(predicted_data)

# Concatenate the original DataFrame with the predicted DataFrame
result_df = pd.concat([df, predicted_df], ignore_index=True)

# Define the column data types for the SQL table
dtype = {
    "year": Integer,
    "month": VARCHAR(20),
    "monthly_sales": Float,
    "moving_average": Float
}

# Save the result to a new table, dropping the existing table if it exists
result_df.to_sql('moving_average_tbl', engine, index=False, if_exists='replace', dtype=dtype)

# Print the updated DataFrame with predictions
print(result_df.tail(6))  # Displaying the last 6 rows to include the predictions
