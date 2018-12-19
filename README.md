<p align="center"><img src="https://raw.githubusercontent.com/jano-may-ball/ticketing/master/logo.png" height="75" alt="Jano"></p>

<p align="center">
<a href="https://app.codeship.com/projects/319077"><img src="https://img.shields.io/codeship/ee9f4010-e46c-0136-4bf8-2a01672139f5/master.svg" alt="Codeship"></a>
 <a href="https://www.codacy.com/app/jano/ticketing?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jano-may-ball/ticketing&amp;utm_campaign=Badge_Grade"><img src="https://img.shields.io/codacy/grade/25ff23782c494860967de4de1eded43a/master.svg" alt="Codacy"></a>
 <a href="https://github.com/jano-may-ball/ticketing/blob/master/README.md"><img src="https://img.shields.io/badge/license-GNU%20AGPL%20v3.0-blue.svg" alt="Licensed under GNU AGPL v3.0"></a>
</p>

Copyright &copy; Andrew Ying and [other contributors](https://github.com/jano-may-ball/ticketing/graphs/contributors)
 2016-2018.

## Installing
*  Clone repository and install dependencies
```bash
git clone https://github.com/jano-may-ball/ticketing.git
cd ticketing
composer install --no-dev
npm install
```
*  Stylesheet can be customised by editing `resources/assets/sass/_variables.scss`
*  Complie stylesheet and scripts
```bash
npm run production
```
*  Edit the configuration file at `.env` and `storage/settings.hjson`
*  Generate the public and private keys for OAuth authentication
```bash
openssl genpkey -algorithm RSA -out storage/oauth-private.key -pkeyopt rsa_keygen_bits:2048
openssl rsa -in storage/oauth-private.key -outform PEM -pubout -out storage/oauth-public.key
```
*  Create tables required by the application
```bash
php jano migrate
```
*  Point web server to `public` directory and **you're done**!

If you do not want to have to worry about the dependencies, you can also use the Docker image [janomayball/ticketing](https://hub.docker.com/r/janomayball/ticketing).

## Contributing
Jano Ticketing System is open source and relies on the help of the community to maintain. You are welcomed to work at issues and submit pull requests. Please note our [Contributing Guide](CONTRIBUTING.md) and our [Contributor Code of Conduct](CODE_OF_CONDUCT.md).

## License
Jano Ticketing System is free software: you can redistribute it and/or modify it under the terms of the GNU [Affero General Public License v3.0](LICENSE.md) as published by the Free Software Foundation. You must preserve all legal notices and author attributions present.

Jano Ticketing System is distributed in the hope that it will be useful, but **WITHOUT ANY WARRANTY**; without even 
the implied warranty of **MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE**.  See the GNU Affero General Public License for more details.

## Credits
The Jano Ticketing System is not possible without the presence of [numerous other projects](CREDITS.md) and the generosity of the sponsors below.

<a href="https://lokalise.co" target="_blank"><img src="https://lokalise.co/img/lokalise_logo_black.png" height="50" alt="Lokalise"></a><br />
<a href="https://www.hackerone.com" target="_blank"><img src="https://www.hackerone.com/sites/default/files/2017-06/HackerOne.png" height="40" alt="HackerOne"></a>