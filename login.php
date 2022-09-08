<?php

$credentials = json_decode(file_get_contents('php://input'));

echo json_encode(['success' => true, 'name' => 'Pennywise']);
