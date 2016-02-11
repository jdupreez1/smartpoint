

UPDATE `Booking`.`User_Groups` SET `Permissions`='{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Manager\":\"false\",\"Finance\":\"true\",\"Rep\":\"false\",\"Driver\":\"false\"}' WHERE `Id`='3';
UPDATE `Booking`.`User_Groups` SET `Permissions`='{\"Admin\":\"false\",\"CompAdmin\":\"true\",\"Manager\":\"false\",\"Finance\":\"false\",\"Rep\":\"false\",\"Driver\":\"false\"}' WHERE `Id`='2';
UPDATE `Booking`.`User_Groups` SET `Permissions`='{\"Admin\":\"true\",\"CompAdmin\":\"true\",\"Manager\":\"true\",\"Finance\":\"true\",\"Rep\":\"true\",\"Driver\":\"true\"}' WHERE `Id`='1';
UPDATE `Booking`.`User_Groups` SET `Permissions`='{\"Admin\":\"false\",\"CompAdmin\":\"true\",\"Manager\":\"true\",\"Finance\":\"false\",\"Rep\":\"false\",\"Driver\":\"false\"}' WHERE `Id`='4';
UPDATE `Booking`.`User_Groups` SET `Permissions`='{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Manager\":\"false\",\"Finance\":\"false\",\"Rep\":\"true\",\"Driver\":\"false\"}' WHERE `Id`='5';
UPDATE `Booking`.`User_Groups` SET `Permissions`='{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Manager\":\"false\",\"Finance\":\"false\",\"Rep\":\"false\",\"Driver\":\"true\"}' WHERE `Id`='6';
