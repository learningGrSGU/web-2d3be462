If you got 403 forbidden error then you need to configure httpd.conf step by step:
1. search for "DocumentRoot"
2. look at <Directory .../htdocs> tag
3. find and replace AllowOverride Allow by AllowOverride None
All done.