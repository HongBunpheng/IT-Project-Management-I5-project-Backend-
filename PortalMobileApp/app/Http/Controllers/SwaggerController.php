<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *   title="ITC Student Portal API",
 *   version="1.0.0"
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8000",
 *   description="Local server"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
class SwaggerController extends Controller {}
