''' This program was written by Nicholas Ellul
This program extracts useful features from our audio files '''

import os
import warnings
import pandas as pd
import librosa
import sklearn
import numpy as np
                                         
warnings.simplefilter(action='ignore', category=FutureWarning)

df = pd.read_csv("C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\Data\\CleanedMetadata.csv")

file_path = "C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\Data\\AudioDataConverted\\"
files = os.listdir(file_path)

def normalize(x, axis=0):
    return sklearn.preprocessing.minmax_scale(x, axis=axis)

# the mfccs function 
keep_mfccs = 13

# define the arrays that the features will be stored in 
stft_array = []
mel_spect_array = []
zero_crossing_array = []

spect_centroid_array = []
spect_centroid_delta_array = []
spect_centroid_accel_array = []

spect_rolloff_array = []
mfccs_array = []
mfccs_delta_array = []
mfccs_accelerate_array = []

# FOR every file in the directory
for f in range(len(files)):
    
    # LOADING DATA
    y, sr = librosa.load(file_path + files[f])

    # trim the audio so there is no silence at the start and end
    audio_file, _ = librosa.effects.trim(y)

    # Calculate Short-Time Fourier Transform (STFT)
    stft = np.abs(librosa.stft(audio_file))
    
    # Calculate Mel Spectrogram
    mel_spectrogram = librosa.feature.melspectrogram(y, sr=sr)
    mel_spect_db = librosa.amplitude_to_db(mel_spectrogram, ref=np.max)

    # Calculate Zero-Crossing Rate
    zero_crossing_rate = librosa.feature.zero_crossing_rate(audio_file, pad=False)

    # Calculate Spectral centroids and their deltas
    spectral_centroids = librosa.feature.spectral_centroid(audio_file, sr=sr)[0]
    spectral_centroid_delta = librosa.feature.delta(spectral_centroids, mode='nearest')
    spectral_centroid_accelerate = librosa.feature.delta(spectral_centroids, order=2, mode='nearest')
    spectral_rolloff = librosa.feature.spectral_rolloff(audio_file, sr=sr)[0]

    # take the of the values and append their mean to the array
    stft_array = np.append(stft_array, np.mean(stft))
    mel_spect_array = np.append(mel_spect_array, np.mean(mel_spect_db))
    zero_crossing_array.append(np.mean(zero_crossing_rate))
    
    spect_centroid_array.append(np.mean(spectral_centroids))
    spect_centroid_delta_array.append(np.mean(spectral_centroid_delta))
    spect_centroid_accel_array.append(np.mean(spectral_centroid_accelerate))
    
    spect_rolloff_array.append(np.mean(spectral_rolloff))

    # Calculate Mel-Frequency Cepstral Co-efficients and their deltas
    mfccs = librosa.feature.mfcc(audio_file, sr=sr, n_mfcc=keep_mfccs)
    mfccs_delta = librosa.feature.delta(mfccs, mode='nearest')
    mfccs_accelerate = librosa.feature.delta(mfccs, order=2, mode='nearest')                       

    # get the mean values each MFCC
    for i in range(len(mfccs)):
        mfccs_array.append(np.mean(mfccs[i]))
        mfccs_delta_array.append(np.mean(mfccs_delta[i]))
        mfccs_accelerate_array.append(np.mean(mfccs_accelerate[i]))

    # to track the progress/speed of the program
    if f % 1000 == 0:
        print(f, 'out of', len(files))

# reshape the MFCC arrays so the inner dimension is one sample

mfccs_array = np.reshape(mfccs_array, (f+1, keep_mfccs))
mfccs_delta_array = np.reshape(mfccs_delta_array, (f+1, keep_mfccs))
mfccs_accelerate_array = np.reshape(mfccs_accelerate_array, (f+1, keep_mfccs))

# add the values to the df
df["stft_mean"] = stft_array
df["mel_spect_mean"] = mel_spect_array
df["zero_crossing_mean"] = zero_crossing_array
df["spect_centroid_mean"] = spect_centroid_array
df["spect_centroid_delta_mean"] = spect_centroid_delta_array
df["spect_centroid_accelerate_mean"] = spect_centroid_accel_array
df["spect_rolloff_mean"] = spect_rolloff_array

# there is N keep_mfccs MFCCs in the array so make a column for each
for i in range(keep_mfccs):
    df["mfcc_" + str(i+1) + "_mean"] = mfccs_array[:, i]
    df["mfcc_delta_" + str(i+1) + "_mean"] = mfccs_delta_array[:, i]
    df["mfcc_accelerate_" + str(i+1) + "_mean"] = mfccs_accelerate_array[:, i]


df.drop("uuid", axis=1, inplace=True)

print(df.head(), df.columns)

#save the dataframe
df.to_csv("C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\Data\\FinalisedData.csv", index=False)
