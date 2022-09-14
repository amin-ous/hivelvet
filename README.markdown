<p align="center">
  <img src="https://github.com/riadvice/hivelvet/blob/develop/hivelvet-frontend/public/images/logo_02.png" alt="Hivelvet Logo">
</p>

# Hivelvet

Hivelvet is an open-source  multipurpose meeting rooms manager for BigBlueButton.

## Features

- Smooth install experience.

- User friendly UI.

- Manage different configuration presets and assign them to rooms.

- Rooms management.

- Users management.

## Components

The web-application is split in two parts:

- A server API.

- A modern front-end.

## Development

- To launch the backend in the development mode, follow these steps :

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1- Start a Command Prompt as an **Administrator**.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2- Run `cd /path/to/cloned/project/`.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3- Run `vagrant up && vagrant ssh` and wait until the end of the process.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4- Run `cp /app/hivelvet-backend/app/config/config-development.sample.ini /app/hivelvet-backend/app/config/config-development.ini`.

- To launch the frontend in the development mode, follow these steps :

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1- Run `cd /app/hivelvet-frontend`.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2- Run `cp /app/tools/hivelvet /app/hivelvet-frontend/hivelvet`.
  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3- Run `sed -i -e 's/\r$//' hivelvet`.
  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4- Run `sed -i -e 's/"hivelvet /".\/hivelvet /g' package.json`.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5- Run `yarn start-dev-installer` to enable the **installer** app or `yarn start-dev` to enable the **web** app.

## Contributing

## Security

## Testing

Backend test:

- From the browser: http://api.hivelvet.test/?statera or http://api.hivelvet.test/?statera=withCoverage

Frontend test:

- To start testing with Cypress, follow these steps :

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1- Enable the **installer** app as described in `Development` heading. 

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2- Run `yarn cypress`.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3- When the Command Prompt displays **Wait 30 seconds until enabling web app (manually)**, terminate the running installer app.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4- Run `yarn start-dev` within 30 seconds.

## Technologies

<p align="center">
  <img src="https://github.com/bcosca/fatfree/raw/master/ui/images/logo.png" href="https://fatfreeframework.com" alt="Fat-Free Framework">
</p>

[Node.js](https://nodejs.org/en/)

[React JS](https://reactjs.org/)

[Redis](https://redis.io/)

[Percona Distribution for PostgreSQL](https://www.percona.com/software/postgresql-distribution)

[TypeSCript](https://www.typescriptlang.org/)

[Cypress](https://www.cypress.io/)

[NGINX](https://www.nginx.com/)

[Vagrant](https://www.vagrantup.com/)
