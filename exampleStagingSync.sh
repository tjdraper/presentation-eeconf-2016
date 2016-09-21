#!/bin/sh

#
# This shell script syncs the staging database and uploads directories to your
# local vagrant environement. It should be run from the shell in your vagrant
# environment (vagrant ssh)
#
# Usage: $ ./exampleStagingSync.sh
#





#---------------------------------------
	# Set Variables
#---------------------------------------

# Get staging DB password
source /home/vagrant/development/scripts/localSyncStagingCreds.sh;

# Project variables
LOCAL_DB_HOST="127.0.0.1";
LOCAL_DB_USER="homestead";
LOCAL_DB_PASS="secret";
LOCAL_DB_NAME="homestead"
LOCAL_PROJECT_PATH="/home/vagrant/development";

BACKUP_DIR=$LOCAL_PROJECT_PATH"/backups/";
STAGING_HOST="STAGING_HOST_HERE";
STAGING_DB_USER="STAGING_DB_USER_HERE";
STAGING_DB_PASS=$stagingDbPass;
STAGING_DB_NAME="DB_NAME_HERE";
STAGING_DIR="staging.site.com";

# Colors
GREEN=`tput setaf 2`;
RESET=`tput sgr0`;

# Date
DATE=$(date +"%Y-%m-%d__%H-%M-%S");

# Backup filenames
STAGING_BACKUP_FILENAME=$STAGING_DB_NAME'-'$DATE'.sql.gz';
LOCAL_BACKUP_FILENAME=$LOCAL_DB_NAME'-'$DATE'.sql.gz';





#---------------------------------------
	# Import remote DB into local
#---------------------------------------

# Back up the local database
echo '';
echo $GREEN'Backing up local database to'$BACKUP_DIR$LOCAL_BACKUP_FILENAME'...'$RESET;
mysqldump -u$LOCAL_DB_USER -p$LOCAL_DB_PASS -h$LOCAL_DB_HOST $LOCAL_DB_NAME --add-drop-table | gzip -9 > $BACKUP_DIR$LOCAL_BACKUP_FILENAME;

# Get the staging DB
echo '';
echo $GREEN'Getting the staging database to'$BACKUP_DIR$STAGING_BACKUP_FILENAME'...'$RESET;
ssh $STAGING_DB_USER@$STAGING_HOST mysqldump -u$STAGING_DB_USER -p$STAGING_DB_PASS -h$STAGING_HOST $STAGING_DB_NAME --add-drop-table | gzip -9 > $BACKUP_DIR$STAGING_BACKUP_FILENAME;

# Clear the local database
echo '';
echo $GREEN'Clearing local database...'$RESET;
mysqldump -u$LOCAL_DB_USER -p$LOCAL_DB_PASS -h$LOCAL_DB_HOST --add-drop-table --no-data $LOCAL_DB_NAME | grep ^DROP | mysql -u$LOCAL_DB_USER -p$LOCAL_DB_PASS -h$LOCAL_DB_HOST $LOCAL_DB_NAME;

# Import the staging database to the local database
echo '';
echo $GREEN'Importing staging database to local database...'$RESET;
gunzip < $BACKUP_DIR$STAGING_BACKUP_FILENAME | mysql -u$LOCAL_DB_USER -p$LOCAL_DB_PASS -h$LOCAL_DB_HOST $LOCAL_DB_NAME;





#---------------------------------------
	# Sync directories
#---------------------------------------

# Sync the uploads directory
echo '';
echo $GREEN'Syncing uploads directories...'$RESET;
rsync -azP --delete -e 'ssh -p 22' forge@$STAGING_HOST:/home/forge/$STAGING_DIR/storage/uploads/ $LOCAL_PROJECT_PATH/public/uploads/





#---------------------------------------
	# All done
#---------------------------------------

echo '';
echo 'Sync complete.';
