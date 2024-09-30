<?php

require __DIR__ . '/../vendor/autoload.php';

use Maincast\App\classes\formHandler;

// Встановлюємо заголовки для JSON-відповіді
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'],'/'));

try {
    switch ($method) {
        case 'GET':
            if (count($path) === 1 && $path[0] === 'tournaments') {
                // GET /api/tournaments: Отримати список всіх турнірів
                $tournaments = formHandler::fetchAll();
                echo json_encode(formatTournaments($tournaments));
            } elseif (count($path) === 2 && $path[0] === 'tournaments') {
                // GET /api/tournaments/{id}: Отримати інформацію про конкретний турнір за ID
                $id = intval($path[1]);
                $tournament = formHandler::fetchById($id);
                echo json_encode(formatTournament($tournament));
            } elseif (count($path) === 2 && $path[0] === 'tournaments' && $path[1] === 'live') {
                // GET /api/tournaments/live: Отримати інформацію тільки про live турніри
                $tournaments = formHandler::fetchLive();
                echo json_encode(formatTournaments($tournaments));
            } else {
                throw new Exception("Unknown route", 404);
            }
            break;

        case 'POST':
            if (count($path) === 1 && $path[0] === 'tournaments') {
                // POST /api/tournaments: Додати новий турнір
                $data = json_decode(file_get_contents('php://input'), true);
                validateTournamentData($data);
                $formHandler = new formHandler(
                    $data['title'],
                    $data['category'],
                    $data['stage'],
                    $data['pool'],
                    $data['live'],
                    $data['beginning'],
                    $data['ending'],
                    $data['description'],
                    $data['url']
                );
                $formHandler->saveDb();
                echo json_encode(['message' => 'Tournament created successfully', 'id' => $formHandler->getId()]);
            } else {
                throw new Exception("Unknown route", 404);
            }
            break;

        case 'PUT':
            if (count($path) === 2 && $path[0] === 'tournaments') {
                // PUT /api/tournaments/{id}: Оновити інформацію про турнір
                $id = intval($path[1]);
                $data = json_decode(file_get_contents('php://input'), true);
                validateTournamentData($data);
                $updatedTournament = formHandler::updateById(
                    $id,
                    $data['title'],
                    $data['category'],
                    $data['stage'],
                    $data['pool'],
                    $data['live'],
                    $data['beginning'],
                    $data['ending'],
                    $data['description'],
                    $data['url']
                );
                echo json_encode(['message' => 'Tournament updated successfully', 'tournament' => formatTournament($updatedTournament)]);
            } else {
                throw new Exception("Unknown route", 404);
            }
            break;

        case 'DELETE':
            if (count($path) === 2 && $path[0] === 'tournaments') {
                // DELETE /api/tournaments/{id}: Видалити турнір за ID
                $id = intval($path[1]);
                formHandler::deleteById($id);
                echo json_encode(['message' => 'Tournament deleted successfully']);
            } else {
                throw new Exception("Unknown route", 404);
            }
            break;

        default:
            throw new Exception("Method Not Allowed", 405);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() === 0 ? 500 : $e->getCode());
    echo json_encode(['error' => $e->getMessage()]);
}

function formatTournaments($tournaments)
{
    $response = [];
    foreach ($tournaments as $tournament) {
        $response[] = formatTournament($tournament);
    }
    return $response;
}

function formatTournament($tournament)
{
    return [
        'title' => $tournament['title'],
        'category' => $tournament['category_name'],
        'stage' => $tournament['stage'],
        'pool' => $tournament['pool'],
        'live' => $tournament['live'] ? 'Yes' : 'No',
        'beginning' => $tournament['beginning'],
        'ending' => $tournament['ending'],
        'description' => $tournament['description'],
        'url' => $tournament['url']
    ];
}

function validateTournamentData($data)
{
    if (empty($data['title']) || empty($data['category']) || empty($data['stage']) ||
        empty($data['pool']) || empty($data['beginning']) || empty($data['ending']) ||
        empty($data['description']) || empty($data['url'])) {
        throw new Exception("Invalid input data", 400);
    }
}
