# Labmanob
## Introducton
Labmanob is a hospital management & invoice system. This project comprises a set of technologies and frameworks. The core system is based on server-side technologies, however, it can be run with ease in local computers. All necessary packages have been integrated inside the system for a seamless one-click start-up, usage, and experience.

![Labmanob Login Panel](https://i.imgur.com/41C2TZz.png)

## Features
1. Can be run offline (can be installed/acts like a native app) or hosted online.
1. Supports multiple OS environment.
2. Options to choose from/switch among multiple database choices like MySQL (tested/preferred for online use-case), SQLite (preferred for offline), PostgreSQL, etc.
3. Uploaded images (via upload module) are encrypted by default

## Modules (Pseudo)
1. Accounts (User Management)
1. Patients
1. Affiliate Partners
2. Test Informations
3. Test Invoices
4. Payments
5. Reports
6. Search
7. Upload (for Image)

## Project Packages
1. <a href="https://github.com/Nilaycb/Labmanob/tree/main/labdoor" target="_blank">Labdoor</a> (CodeIgniter)
1. [PHP Desktop](https://github.com/cztomczak/phpdesktop)
1. **Distribution Packaging:** [Inno Setup Script](../master/Labmanob_dist-cd-inno_setup_script-(vc_redist_x86-post_install).iss) (for Windows)
1. **Source Code Encoder Engine:** *will be published...*

## Updating Labmanob (Windows)
<a href="https://github.com/Nilaycb/Labmanob/tree/main/batch_scripts" target="_blank">batch_scripts</a> directory contains supportive scripts to automate some/most of the labor-intensive tasks required for pushing updates. 

To update Labmanob, these steps can be followed:
  1. ```cd``` to the directory where Labmanob is installed ("**Labmanob**" directory should be listed in the current working directory)
  2. copy the files "*run_pre_update_setup.bat*" and "*run_post_update_setup.bat*" to the current working directory
  3. run the file "*run_pre_update_setup.bat*" [ It will create a temp backup folder (if doesn't exist already), will start backing up database (in case of SQLite) and other necessary files ]
  4. Uninstall Labmanob and install the update version
  5. Finally, run the file "*run_post_update_setup.bat*" [ It will restore database (in case of SQLite) and other necessary files (logs, uploads, QR codes) ]

## Support Libraries/Docs
1. [PHP Desktop](https://github.com/cztomczak/phpdesktop)
1. **Distribution Packaging:** [Inno Setup](https://github.com/jrsoftware/issrc) (Script-driven App Installer for Windows) / [AppImage](https://appimage.org) (Linux)
1. **Source Code Encoder:** [ColdevProLayer](http://coldev.blogspot.com) (for Source Code Protection)
1. [ResourceHacker](http://www.angusj.com/resourcehacker) (Embedded Icon Editor for EXE files)

*Detailed documentation is being written.*
