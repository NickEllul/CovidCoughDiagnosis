import pandas as pd
import numpy as np
from collections import Counter

from sklearn.utils import resample
from sklearn.metrics import confusion_matrix, classification_report, accuracy_score
from sklearn.model_selection import train_test_split

from catboost import CatBoostClassifier

from imblearn.over_sampling import SMOTE
from imblearn.under_sampling import RandomUnderSampler
from imblearn.pipeline import Pipeline
from matplotlib import pyplot

df = pd.read_csv("C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\Data\\FinalisedData.csv")

# split into label and inputs
y = df['label']
X = df.drop('label', axis=1)

# split the data into train and test set
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=123)
eval_set = [(X_test, y_test)]

print('y_train before SMOTE \nHealthy: ', y_train.value_counts()[0], '\nSymptomatic:', y_train.value_counts()[1], '\n\n')

# define pipeline
over = SMOTE(sampling_strategy=1)
under = RandomUnderSampler(sampling_strategy=1)
steps = [('o', over), ('u', under)]
pipeline = Pipeline(steps=steps)

# transform the dataset
X_train, y_train = pipeline.fit_resample(X_train, y_train)

print('y_train after SMOTE \nHealthy: ', y_train.value_counts()[0], '\nSymptomatic:', y_train.value_counts()[1], '\n\n')

# Training the CatBoost Classifier
model = CatBoostClassifier()

model.fit(X_train, y_train, early_stopping_rounds=100, eval_set=eval_set, verbose=True)

# test the models accuracy
y_pred = model.predict(X_test)
predictions = [round(value) for value in y_pred]
accuracy = accuracy_score(y_test, predictions)
print("Accuracy: %.2f%%" % (accuracy * 100.0))
