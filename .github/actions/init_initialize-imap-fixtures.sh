#!/bin/bash -e

ROOT_DIR=$(readlink -f "$(dirname $0)/../..")

echo "Initialize email fixtures"
# sudo doveadm mailbox create -u runner mailbox
sudo doveadm mailbox create -u testuser INBOX
sudo doveadm purge -u testuser
for f in `ls $ROOT_DIR/tests/emails-tests/*.eml`; do
  cat $f | sudo -H -u testuser bash -c "getmail_maildir /home/testuser/"
done
