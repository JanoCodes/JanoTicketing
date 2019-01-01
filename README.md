<p align="center">
<img src="https://raw.githubusercontent.com/jano-may-ball/ticketing/master/logo.png"
height="75" alt="Jano">
</p>

<p align="center">
<a href="https://app.codeship.com/projects/319077" target="_blank"><img
src="https://img.shields.io/codeship/ee9f4010-e46c-0136-4bf8-2a01672139f5/master.svg"
alt="Codeship"></a>
<a href="https://www.codacy.com/app/jano/ticketing?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jano-may-ball/ticketing&amp;utm_campaign=Badge_Grade"
target="_blank"><img
src="https://img.shields.io/codacy/grade/25ff23782c494860967de4de1eded43a/master.svg"
alt="Codacy"></a>
<a href="https://app.fossa.io/projects/custom%2B372%2Fgit%40github.com%3Ajano-may-ball%2Fticketing.git?ref=badge_shield"
alt="FOSSA Status"><img src="https://app.fossa.io/api/projects/custom%2B372%2Fgit%40github.com%3Ajano-may-ball%2Fticketing.git.svg?type=shield"
alt ="FOSSA"></a>
<a href="https://github.com/jano-may-ball/ticketing/blob/master/README.md"
target="_blank"><img src="https://img.shields.io/badge/license-GNU%20AGPL%20v3.0-blue.svg"
alt="Licensed under GNU AGPL v3.0"></a>
</p>

<p align="center">
Copyright &copy; Andrew Ying and <a
href="https://github.com/jano-may-ball/ticketing/graphs/contributors" target="_blank">
other contributors</a> 2016-2018.
</p>

## Installing

### Requirements

If you're not using the Docker image, you will need to make sure that the following are
installed on your machine:

* Web server (e.g. Apache or Nginx)
* PHP, version 7.1 or above
* Database (either MySQL or MariaDB)
* Node.js and npm

### Steps

* Clone repository and install dependencies
```bash
git clone https://github.com/jano-may-ball/ticketing.git
cd ticketing
composer install --no-dev
npm install
```
* Stylesheet can be customised by editing `resources/assets/sass/_variables.scss`
* Complie stylesheet and scripts
```bash
npm run production
```
* Edit the configuration file at `.env` and `storage/settings.hjson`
* Generate the public and private keys for OAuth authentication
```bash
openssl genpkey -algorithm RSA -out storage/oauth-private.key -pkeyopt rsa_keygen_bits:2048
openssl rsa -in storage/oauth-private.key -outform PEM -pubout -out storage/oauth-public.key
```
* Create tables required by the application
```bash
php jano migrate
```
* Point web server to `public` directory and **you're done**!

If you do not want to have to worry about the dependencies, you can also use the Docker
image [janomayball/ticketing](https://hub.docker.com/r/janomayball/ticketing).

## Contributing
Jano Ticketing System is open source and relies on the help of the community to maintain.
You are welcomed to work at issues and submit pull requests. Please note our
[Contributing Guide](CONTRIBUTING.md) and our
[Contributor Code of Conduct](CODE_OF_CONDUCT.md).

## License
Jano Ticketing System is free software: you can redistribute it and/or modify it under
the terms of the [GNU Affero General Public License v3.0](LICENSE.md) supplemented by
[additional permissions and terms](COPYING.md).

Jano Ticketing System is distributed in the hope that it will be useful, but **WITHOUT
ANY WARRANTY**; without even the implied warranty of **MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE**. See the GNU Affero General Public License for more details.

## Credits
The Jano Ticketing System is not possible without the presence of
[numerous other projects](CREDITS.md) and the generosity of the sponsors below.

<table>
<tr>
<td style="text-align:center;">
<a href="https://www.digitalocean.com/">
<img src="https://opensource.nyc3.cdn.digitaloceanspaces.com/attribution/assets/SVG/DO_Logo_horizontal_blue.svg" 
alt="DigitalOcean" height="45px">
</a><br />Server Hosting
</td>
<td style="text-align:center;">
<a href="https://www.keycdn.com"><img src="https://logos.keycdn.com/keycdn-logo.png" 
alt="KeyCDN" height="50px"></a><br />Global CDN
</td>
</tr>
<tr>
<td style="text-align:center;">
<a href="https://auth0.com/?utm_source=oss&utm_medium=gp&utm_campaign=oss" target="_blank">
<img height="60px" alt="JWT Auth for open source projects"
src="https://cdn.auth0.com/oss/badges/a0-badge-light.png" /></a><br />Single Sign-On
</td>
<td style="text-align:center;">
<a href="https://www.browserstack.com/" target="_blank">
<img src="https://assets.janoticketing.co.uk/images/browserstack.png" height="50px" 
alt="BrowserStack" /></a><br />Browser compatibility testing
</td>
</tr>
</table>

* Translation management by [Lokalise](https://lokalise.co)
* License management by [FOSSA](https://fossa.com)
