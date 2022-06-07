''' this program was written by Nicholas Ellul
This script converts the webm and ogg files from the dataset into wav files'''
import os

file_path = "C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\"
files = os.listdir(file_path + "Data\\AudioData\\")

print(len(files))
for f in files:    
    # if the file is an ogg file only take
    if f[-3:] == "ogg":
        p = "ffmpeg -i ..\\..\\..\\..\\New\\Data\\AudioData\\" + f + " -ac 1 ..\\..\\..\\..\\New\\Data\\AudioDataConverted\\" + f[:-4] + ".wav"
    elif f[-4:] == "webm":
        p = "ffmpeg -i ..\\..\\..\\..\\New\\Data\\AudioData\\" + f + " -ac 1 ..\\..\\..\\..\\New\\Data\\AudioDataConverted\\" + f[:-5] + ".wav"    
    os.system('cd C:\\Users\\Nicho\\Documents\\SCHOOL\\New\\Programs\\ffmpeg-master-latest-win64-gpl\\bin\\ && ' + p)


print(len(os.listdir(file_path + "Data\\AudioDataConverted\\")))
