<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/friends/all', function (Request $request, Response $response) {
    $sql = "select * from friends";

    try {
        $db = new Db();
        $conn = $db->connect();

        $stm = $conn->query($sql);
        $friends = $stm->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = [
            "message" => $e->getMessage(),
        ];

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->get('/friends/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $sql = "select * from friends where id=$id";

    try {
        $db = new Db();
        $conn = $db->connect();

        $stm = $conn->query($sql);
        $friend = $stm->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($friend));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = [
            "message" => $e->getMessage(),
        ];

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->post('/friends/add', function (Request $request, Response $response, array $args) {
    $email = $request->getParam('email');
    $display_name = $request->getParam('display_name');
    $phone = $request->getParam('phone');

    $sql = "insert into friends(email, display_name, phone) values(:email, :display_name, :phone)";

    try {
        $db = new Db();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':display_name', $display_name);
        $stmt->bindParam(':phone', $phone);

        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = [
            "message" => $e->getMessage(),
        ];

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

$app->delete('/friends/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];

    $sql = "delete from friends where id=$id";

    try {
        $db = new Db();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = [
            "message" => $e->getMessage(),
        ];

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});