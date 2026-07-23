import os
import glob

html_files = glob.glob(r'c:\Users\luizn\Documents\1-PROGRAMAS\Foco-15\public\*.html')

for fpath in html_files:
    with open(fpath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if 'report.css' in content and 'css/report.css' not in content:
        content = content.replace(
            '<link rel="stylesheet" href="report.css',
            '<link rel="stylesheet" href="css/report.css"><link rel="stylesheet" href="report.css'
        )
        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(content)
        print('Updated css link in:', fpath)
