#!/bin/bash -e

ROOT_DIR=$(readlink -f "$(dirname $0)/../..")

echo "Initialize LDAP fixtures"
for f in `ls $ROOT_DIR/tests/LDAP/ldif/*glpi.ldif`; do
  # Delete all LDAP entries (in reverse ordre compared to creation)
  # but ignore errors as these entries may not exists.
  (tac $f | grep -E '^dn:' | sed -E "s/^dn: (.*)$/\\1/" | ldapdelete -x -H ldap://127.0.0.1:389/ -D "cn=admin,dc=glpi,dc=org" -w insecure -c) \
  || true
done
for f in `ls $ROOT_DIR/tests/LDAP/ldif/*glpi.ldif`; do
  cat $f | ldapadd -x -H ldap://127.0.0.1:389/ -D "cn=admin,dc=glpi,dc=org" -w insecure
done
