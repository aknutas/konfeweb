<?php
set_include_path(get_include_path() . PATH_SEPARATOR . "src/");
include('./src/settings.ini');
include('./src/controllers/admincontroller.php');

//Opening DB connection
date_default_timezone_set($timezone);
$db = new SQLiteDatabase("./src/models/database.sqlite");

//Executing queries that create the table schema
$db->queryExec("CREATE TABLE [conference] ([kid] INTEGER NOT NULL PRIMARY KEY, [name] TEXT, [organization] TEXT);");
$db->queryExec("CREATE TABLE [feedback] ([cid] INTEGER NOT NULL PRIMARY KEY, [datetime] DATETIME, [comment] TEXT, [old] INTEGER(1,0), [lid] INTEGER NOT NULL REFERENCES [lecture](lid) ON DELETE CASCADE ON UPDATE CASCADE ON INSERT CASCADE);");
$db->queryExec("CREATE TABLE [lecture] ([lid] INTEGER NOT NULL PRIMARY KEY, [kid] INTEGER NOT NULL REFERENCES [conference](kid) ON DELETE CASCADE ON UPDATE CASCADE ON INSERT CASCADE, [name] TEXT, [lecturer] TEXT, [contact] TEXT);");
$db->queryExec("CREATE TABLE [settings] ([sid] INTEGER NOT NULL PRIMARY KEY, [setting] TEXT, [value] TEXT);");
$db->queryExec("CREATE TABLE [user] ([uid] INTEGER PRIMARY KEY, [user] TEXT NOT NULL, [pass] TEXT NOT NULL, [admin] INTEGER);");
$db->queryExec("CREATE UNIQUE INDEX [idx_feedback_cid_lid] ON [feedback] ([lid], [cid]);");
$db->queryExec("CREATE UNIQUE INDEX [idx_settings_setting] ON [settings] ([setting]);");
$db->queryExec("CREATE UNIQUE INDEX [idx_user_user] ON [user] ([user]);");
$db->queryExec("CREATE TRIGGER [fk_feedback_lecture_del1] BEFORE DELETE ON [lecture] WHEN (old.[lid] IN (SELECT [lid] FROM [feedback] GROUP BY [lid])) BEGIN
DELETE FROM [feedback] WHERE [lid] = old.[lid];
END;");
$db->queryExec("CREATE TRIGGER [fk_feedback_lecture_ins1] BEFORE INSERT ON [feedback] WHEN (new.[lid] NOT IN (SELECT [lid] FROM [lecture] GROUP BY [lid])) BEGIN
SELECT RAISE( ABORT, 'Foreign key violated: fk_feedback_lecture_ins1' );
END;");
$db->queryExec("CREATE TRIGGER [fk_feedback_lecture_upd1] BEFORE UPDATE ON [lecture] WHEN (old.[lid] IN (SELECT [lid] FROM [feedback] GROUP BY [lid])) BEGIN
UPDATE [feedback] SET [lid] = new.[lid] WHERE [lid] = old.[lid];
END;");
$db->queryExec("CREATE TRIGGER [fk_lecture_conference_del] BEFORE DELETE ON [conference] WHEN (old.[kid] IN (SELECT [kid] FROM [lecture] GROUP BY [kid])) BEGIN
DELETE FROM [lecture] WHERE [kid] = old.[kid];
END;");
$db->queryExec("CREATE TRIGGER [fk_lecture_conference_ins] BEFORE INSERT ON [lecture] WHEN (new.[kid] NOT IN (SELECT [kid] FROM [conference] GROUP BY [kid])) BEGIN
SELECT RAISE( ABORT, 'Foreign key violated: fk_lecture_conference_ins' );
END;");
$db->queryExec("CREATE TRIGGER [fk_lecture_conference_upd] BEFORE UPDATE ON [conference] WHEN (old.[kid] IN (SELECT [kid] FROM [lecture] GROUP BY [kid])) BEGIN
UPDATE [lecture] SET [kid] = new.[kid] WHERE [kid] = old.[kid];
END;");

//Creating default values
//
$db->queryExec("INSERT INTO conference(name, organization) VALUES ('" . "default" . "', '" . "default" . "');");
$db->queryExec("INSERT INTO lecture(kid, name, contact) VALUES (" . "1" ." , '". "Default Lecture" ."', '". "default@example.com" ."');");
$db->queryExec("INSERT INTO settings(setting, value) VALUES ('conference', 1);");
$db->queryExec("INSERT INTO settings(setting, value) VALUES ('lecture', 1);");
$db->queryExec("INSERT INTO settings(setting, value) VALUES ('device', 'guruplug');");
$db->queryExec("INSERT INTO settings(setting, value) VALUES ('ssid', '-');");
$db->queryExec("INSERT INTO settings(setting, value) VALUES ('channel', '-');");

//Reading input for setting the first admin user
print("Enter the username for the first admin user: ");
$name = fgets(STDIN);
$tname = trim($name, "\n");
print("Enter the password for the first admin user: ");
$passwd = fgets(STDIN);
$tpasswd = trim($passwd, "\n");

//Adding the user into the database
$user = new User($db);
$user->addAdmin($tname, $tpasswd);

//Printing confirmation and quitting
print("Setup complete\n");
exit(0);

?>
