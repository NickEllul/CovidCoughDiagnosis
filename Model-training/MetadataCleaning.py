''' This program was written by Nicholas Ellul
This program cleans our metadata and performs actions such as dropping useless features
and poorly documented ones '''

import pandas as pd
import os
import shutil



df = pd.read_csv('..\Data\public_dataset\metadata_compiled.csv')

# drop NaN values that when they exist in these rows
df.dropna(subset=['gender',
                  'respiratory_condition',
                  'fever_muscle_pain',
                  'status'], how='all', inplace=True)

# only keep these columns as they are the most well documented
df = df[['uuid',
         'gender',
         'respiratory_condition',
         'fever_muscle_pain',
         'status']]

# binary encoding categories in the metadata csv
df.replace({'gender':{"male":0, "female":1, 'other':2},
            'respiratory_condition':{True:0, False:1},
            'fever_muscle_pain':{True:0, False:1},
            'status': {'healthy': 0, 'symptomatic': 1, 'COVID-19':1}},
            inplace=True)

# create the labels from the status column
df["label"] = df["status"]
df.drop("status", axis=1, inplace=True)
new_path = '..\\Data\\Audio Data\\'
old_path = '..\\Data\\public_dataset\\'


# create the filepath if it doesnt exist
try:
    os.mkdir(new_path)
except:
    pass


# iterate over the audio files only keep the ones we need
for file in df['uuid']:
    try:
        shutil.copy(old_path + file + '.webm',
                    new_path + file + '.webm')
    except:
        shutil.copy(old_path + file + '.ogg',
                    new_path + file + '.ogg')


df.to_csv('..\\Data\\CleanedMetaData.csv', index=False)
