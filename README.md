<p style="text-align:center;"><img src="https://raw.githubusercontent.com/jano-may-ball/ticketing/master/logo.png" height="75" alt="Jano"></p>

[![Licensed under GNU GPL v3.0](https://img.shields.io/badge/license-GNU%20GPL%20v3.0-blue.svg)](https://github.com/jano-may-ball/ticketing/blob/master/README.md) [![Code Climate](https://img.shields.io/codeclimate/maintainability/jano-may-ball/ticketing.svg)](https://codeclimate.com/github/jano-may-ball/ticketing)

Copyright &copy; Andrew Ying and [other contributors](https://github.com/jano-may-ball/ticketing/graphs/contributors) 
2016-2018.

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
php jano migrate
```
* Point web server to `public` directory and **you're done**!

## Contributing
Jano Ticketing System is open source and relies on the help of the community to maintain. You are welcomed to work at issues and submit pull requests. Please note our [Contributing Guide](CONTRIBUTING.md) and our [Contributor Code of Conduct](CODE_OF_CONDUCT.md).

## License
Jano Ticketing System is free software: you can redistribute it and/or modify it under the terms of the GNU [General Public License v3.0](LICENSE.md) as published by the Free Software Foundation. You must preserve all legal notices and author attributions present.

Jano Ticketing System is distributed in the hope that it will be useful, but **WITHOUT ANY WARRANTY**; without even the implied warranty of **MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE**.  See the GNU General Public License for more details.

## Credits
The Jano Ticketing System is not possible without the presence of [numerous other projects](CREDITS.md) and the 
generosity of the sponsors below.

<a href="https://lokalise.co" target="_blank"><img src="https://lokalise.co/img/lokalise_logo_black.png" height="50" alt="Lokalise"></a>