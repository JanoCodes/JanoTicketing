<p style="text-align:center;"><img src="https://raw.githubusercontent.com/jano-may-ball/ticketing/master/logo.png" height="75" alt="Jano"></p>

<p style="text-align:center;"><a href="https://build.janoticketing.com/job/Jano%20Ticketing/" target="blank"><img src="https://build.janoticketing.com/buildStatus/icon?job=Jano%20Ticketing" alt="Build Status"></a>
<a href="https://github.com/jano-may-ball/ticketing/blob/master/README.md"><img src="https://img.shields.io/badge/license-GNU%20GPL%20v3.0-blue.svg" alt="Licensed under GNU GPL v3.0"></a></p>

Copyright &copy; Andrew Ying 2016-2017

## Installing
* Clone repository and install dependencies
```
git clone https://github.com/jano-may-ball/ticketing.git
cd ticketing
composer install --no-dev
npm install
```
* Stylesheet can be customised by editing `resources/assets/sass/_variables.scss`
* Complie stylesheet and scripts
```
npm run production
```
* Edit the configuration file at `.env` and `storage/settings.hjson`
* Create tables required by the application
```
php artisan migrate
```
* Point web server to `public` directory and **you're done**!

## Contributing
Jano Ticketing System is open source and relies on the help of the community to maintain. You are welcomed to work at issues and submit pull requests. Please note our [Contributing Guide](CONTRIBUTING.md) and our [Contributor Code of Conduct](CODE_OF_CONDUCT.md).

## License
Jano Ticketing System is free software: you can redistribute it and/or modify it under the terms of the GNU [General Public License v3.0](LICENSE.md) as published by the Free Software Foundation. You must preserve all legal notices and author attributions present.

Jano Ticketing System is distributed in the hope that it will be useful, but **WITHOUT ANY WARRANTY**; without even the implied warranty of **MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE**.  See the GNU General Public License for more details.

## Credits
The Jano Ticketing System is not possible without the presence of numerous other project which are listed [here](CREDITS.md). 

We also thank the following sponsors for their help in funding the ongoing development of the Jano Ticketing System.

| Supported by |
| --- |
| <a href="https://www.digitalocean.com" target="_blank" alt="DigitalOcean"><img src="https://www.digitalocean.com/assets/media/logos-badges/png/DO_Logo_Horizontal_Blue-3db19536.png" width="150px"></a> |