#!C:/Users/Nicho/AppData/Local/Programs/Python/Python310/python.exe
import requests
import cgi
import cgitb; cgitb.enable()
from joblib import load
import librosa
import numpy as np
import io

def preprocess(file, keep_mfccs):
    output = []
    y, sr = librosa.load(io.BytesIO(file))
    audio, _ = librosa.effects.trim(y)

    # Calculate Short-Time Fourier Transform (STFT)
    output.append(np.mean(np.abs(librosa.stft(audio))))

    # Calculate Mel Spectrogram
    mel_spectrogram = librosa.feature.melspectrogram(audio, sr=sr)
    mel_spect_db = librosa.amplitude_to_db(mel_spectrogram, ref=np.max)
    output.append(np.mean(mel_spect_db))

    # Calculate Zero-Crossing Rate
    zero_crossing_rate = librosa.feature.zero_crossing_rate(audio, pad=False)
    output.append(np.mean(zero_crossing_rate))

    # Calculate Spectral centroids and their deltas
    spectral_centroids = librosa.feature.spectral_centroid(audio, sr=sr)[0]
    spectral_centroid_delta = librosa.feature.delta(spectral_centroids, mode='nearest')
    spectral_centroid_accelerate = librosa.feature.delta(spectral_centroids, order=2, mode='nearest')
    spectral_rolloff = librosa.feature.spectral_rolloff(audio, sr=sr)[0]

    # adding to the output
    output.append(np.mean(spectral_centroids))
    output.append(np.mean(spectral_centroid_delta))
    output.append(np.mean(spectral_centroid_accelerate))
    output.append(np.mean(spectral_rolloff))

    # Calculate Mel-Frequency Cepstral Co-efficients and their deltas
    mfccs = librosa.feature.mfcc(audio, sr=sr, n_mfcc=keep_mfccs)
    mfccs_delta = librosa.feature.delta(mfccs, mode='nearest')
    mfccs_accelerate = librosa.feature.delta(mfccs, order=2, mode='nearest')   

    # get the mean values each MFCC
    for i in range(len(mfccs)):
        output.append(np.mean(mfccs[i]))
        output.append(np.mean(mfccs_delta[i]))
        output.append(np.mean(mfccs_accelerate[i]))
    return output

form = cgi.FieldStorage()
aches =  form.getvalue('aches')
resp =  form.getvalue('respiratory')
audio =  form.getvalue('audio')

if aches:
    aches = 1
else:
    aches = 0

if resp:
    respiratory = 1
else:
    respiratory = 0

print("Content-type: text/html\n\n")

audio = preprocess(audio, 13)

symptoms = [aches, respiratory]
symptoms = np.concatenate((symptoms, audio))

# load the model
model_file = "weights//XGBoostWeights.pkl"
model = load(model_file)

pred = model.predict([symptoms])

if pred == 0:
    pred = "COVID-19 virus was NOT DETECTED by our model if you feel unwell, call your doctor"

elif pred == 1:
    pred = "COVID-19 virus WAS DETECTED by our model seek a medical professional"

url = 'http://localhost/CovidDiagnosis/predict.php?'
param = {'pred' : pred}

r = requests.post(url, data=param)
print(r.text)
