read -s -p "enter MySql root's password: " pws
echo ""
read -p "do you want 'limba' MySql user to be created (y/n) ? " ouinon
echo ""

if [ "$ouinon" = "y" ] || [ "$ouinon" = "Y" ]; then
{
    mysql -u root -p"$pws" --default-character-set=utf8 < USER.sql
    mysql -u root -p"$pws" --default-character-set=utf8 < DDL.sql
	mysql -u root -p"$pws" --default-character-set=utf8 < DATA.sql
}
elif [ "$ouinon" = "n" ] || [ "$ouinon" = "N" ]; then
{
    mysql -u root -p"$pws" --default-character-set=utf8 < DDL.sql
	mysql -u root -p"$pws" --default-character-set=utf8 < DATA.sql
}
else
{
  echo "please answer with (y/n)"
}
fi