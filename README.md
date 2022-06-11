# geometry-calculator
A Symfony based geometry calculation api developed for Horus Music that allows calculation of surface area, diameter and circumference of shapes. 

## Endpoints:

- `GET /`,  home endpoint.
- `GET /shape`,  calculate surface areas, diameters and circumfrences of shapes.
- `GET /circle/{radius}`, calculate surface area, diameter and circumfrence of circle.
- `GET /triangle/{a}/{b}/{c}` calculate surface area, diameter and circumfrence of triangle.

## Installation

1. Clone this repo.

2. Navigate to the symfony directory.

3. Run ```composer install``` command to install bundles

4. Navigate back to the root directory and issue ```symfony serve``` command to serve the project

5. Lastly, navigate to `localhost:8000` in your browser or open Postman application to access the enpoint on `localhost:80000` or issue curl request `localhost:80000`.