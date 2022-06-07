''' This program was written by Nicholas Ellul
This program extracts useful features from our audio files and displays them as plots/graphs '''
import librosa
import librosa.display
import matplotlib.pyplot as plt 
import numpy as np
import sklearn

import os

# LOADING DATA
y, sr = librosa.load("C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\Data\\AudioDataConverted\\00a0156b-7179-4773-8a2c-4bb919e076bd.wav")
audio_file, _ = librosa.effects.trim(y)

#plot simple 2D representation
plt.figure(figsize = (16, 6))
librosa.display.waveshow(y = audio_file, sr = sr, color = "#A300F9");
plt.title("Audio of Covid Positive Patient", fontsize = 23);
plt.show()

# Default FFT window size
n_fft = 2048 # FFT window size
hop_length = 512 # number audio of frames between STFT columns


def normalize(x, axis=0):
    return sklearn.preprocessing.minmax_scale(x, axis=axis)


# Short-Time Fourier Transform (STFT)
STFT = np.abs(librosa.stft(audio_file, n_fft = n_fft, hop_length = hop_length))

# Plotting Short-Time Fourier Transform (STFT)
plt.figure(figsize = (16, 6))
plt.title("Short-time Fourier Transfrom of Covid Positive Patient", fontsize = 23);
plt.plot(STFT);
plt.show()



# Mel Spectrogram
mel_spectrogram = librosa.feature.melspectrogram(y, sr=sr)
mel_spect_db = librosa.amplitude_to_db(mel_spectrogram, ref=np.max)

# Plotting Mel Spectrogram
plt.figure(figsize = (16, 6))
librosa.display.specshow(mel_spect_db, sr=sr, hop_length=hop_length, x_axis = 'time', y_axis = 'log',
                        cmap = 'cool');
plt.colorbar();
plt.title("Mel Spectrogram of Covid Positive Patient", fontsize = 23);
plt.show()


# Zero Crossings
zero_crossings = librosa.zero_crossings(audio_file, pad=False)


# Calculate the Spectral Centroids
spectral_centroids = librosa.feature.spectral_centroid(audio_file, sr=sr)[0]

# Plotting the Spectral Centroid along the waveform
frames = range(len(spectral_centroids))
t = librosa.frames_to_time(frames)
plt.figure(figsize = (16, 6))
plt.title("Spectral Centroid of Covid Positive Patient", fontsize = 23);
librosa.display.waveshow(audio_file, sr=sr, alpha=0.4, color = '#A300F9');
plt.plot(t, normalize(spectral_centroids), color='#FFB100');
plt.show()



# Spectral Rolloff
spectral_rolloff = librosa.feature.spectral_rolloff(audio_file, sr=sr)[0]

# Plotting Spectral Rolloff
librosa.display.waveshow(audio_file, sr=sr, alpha=0.4, color = '#A300F9');
plt.title("Spectral Rolloff of Covid Positive Patient", fontsize = 23);
plt.plot(t, normalize(spectral_rolloff), color='#FFB100');
plt.show()


# Mel-Frequency Cepstral Co-efficients
mfccs = librosa.feature.mfcc(audio_file, sr=sr)
mfccs = normalize(mfccs, axis=1)

plt.figure(figsize = (16, 6))
plt.title("Mel-Frequency Cepstral Co-efficients of Covid Positive Patient", fontsize = 23);
librosa.display.specshow(mfccs, sr=sr, x_axis='time', cmap = 'cool');
plt.show()
