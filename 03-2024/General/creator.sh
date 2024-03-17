#!/bin/bash

# Create the automation user
useradd -m -s /bin/bash automation
echo "automation:letmein" | chpasswd

# Configure SSH to listen on port 13337 for the automation user
sed -i 's/^#Port 22/Port 13337/' /etc/ssh/sshd_config
service ssh restart

# Generate folders, files, and subfolders
mkdir /home/automation/folders
cd /home/automation/folders
for ((i=1; i<=500; i++)); do
    folder_name=$(openssl rand -hex 10)
    mkdir "$folder_name"
    cd "$folder_name"
    touch file.txt
    echo "I am fake flag" > file.txt
    mkdir subfolder1 subfolder2 subfolder3
    touch subfolder1/file1.txt subfolder2/file2.txt subfolder3/file3.txt
    echo "I am fake flag" > subfolder1/file1.txt
    echo "I am fake flag" > subfolder2/file2.txt
    echo "I am fake flag" > subfolder3/file3.txt
    if [ $((RANDOM % 500)) -eq 0 ]; then
        cp flag.txt > subfolder3/
    fi
    cd ..
done

# Set permissions to allow read-only access for SSH-connected users
chown -R automation:automation /home/automation/folders
chmod -R 555 /home/automation/folders


