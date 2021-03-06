<?php

/**
 * дебуг вывод массивов
 * @param array
 */
function arrPrint($arr) {
    echo '<pre>';
    print_r($arr);
    echo '<pre>';
}


/**
 * Переводит месяц на русский язык
 * @param int $month номер месяца
 * @return array or false
 */

function getMonthRus($month) {
    
    $monthRus = [
        1   => 'Января',
        2   => 'Февраля',
        3   => 'Марта',
        4   => 'Апреля',
        5   => 'Мая',
        6   => 'Июня',
        7   => 'Июля',
        8   => 'Августа',
        9   => 'Сентября',
        10  => 'Октября',
        11  => 'Ноября',
        12  => 'Декабря'
    ];

    if (isset($month)) {
        return $monthRus[$month];
    }
    return false;
}

function getDayRus($day) {
    $days = array(
        // в формате w возвращает порядковый номер дня недели от 0 до 6. 0 -вс 
        'Воскресенье',
        'Понедельник',
        'Вторник', 
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота'
    );
    return $days[$day];
}

function getShortDayRus($day) {
    $days = array(
        // в формате w возвращает порядковый номер дня недели от 0 до 6. 0 -вс 
        'ВС',
        'ПН',
        'ВТ', 
        'СР',
        'ЧТ',
        'ПТ',
        'СБ'
    );
    return $days[$day];
}


/**
 * Достает сезоны из базы 
 * @param null
 * @return array or false
 */
function getSeason() {
    
    $db = DB::getConnection();
    $sql = "SELECT id, name, season_banner as banner, season_logo as logo
            FROM seasons";
    $result = $db->prepare($sql); 
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();       
    $seasons = $result->fetchAll();
    
    if($seasons){
        return $seasons;
    }
    
    return false;
}


/**
 * Достает игры из базы 
 * @param int $limit 
 * @return array or false
 */

function getGames($limit) {

    
    if ($limit) {

        $db = DB::getConnection();

        $sql = "SELECT 
            g.id,
            g.name as name,
            g.start_date as date,
            g.description as description,
            g.game_logo as logo,
            g.game_banner as banner,
            g.season_id as season_id,
            l.name as bar,
            l.adress
            FROM games g  
            LEFT JOIN location l on l.id = g.locationID 
            WHERE g.active = 1  AND g.start_date >= NOW()
            ORDER BY g.start_date LIMIT :limit";
        
        
        $result = $db->prepare($sql);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();       
        $games = $result->fetchAll();

        if($games){
            return $games;
        }
    }
    return false;
}

/**
 * Достает игры из базы 
 * @param int $limit row limt
 * @return array or false
 */

function getAllGames() {
    
        $db = DB::getConnection();

        $sql = "SELECT 
            g.id,
            g.name as name,
            g.start_date as date,
            g.description as description,
            g.game_logo as logo,
            g.game_banner as banner,
            g.season_id as season_id,
            l.name as bar,
            l.adress
            FROM games g  
            LEFT JOIN location l on l.id = g.locationID 
            WHERE g.active = 1  AND g.start_date >= NOW() 
            ORDER BY g.start_date";
        
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();       
        $games = $result->fetchAll();

        if($games){
            return $games;
        }
        
    return false;
}

/**
 * Достает игры из базы по сезону
 * @param int $id row game id
 * @return array or false
 */

function getGamesBySeason($season) {

    if ($season) {

        $db = DB::getConnection();

        $sql = "SELECT 
            g.id,
            g.name as name,
            g.start_date as date,
            g.description as description,
            g.game_logo as logo,
            g.game_banner as banner,
            l.name as bar,
            l.adress
            FROM games g  
            LEFT JOIN location l on l.id = g.locationID 
            WHERE g.active = 1 
            AND g.season_id = :season
            ORDER BY g.start_date";
        
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->bindParam(':season', $season, PDO::PARAM_INT);
        $result->execute();       
        $games = $result->fetchAll();

        if($games){
            return $games;
        }
    }
    return false;
}

/**
 * Достает результаты игры по id игры
 * @param int $id row game id
 * @return array or false
 */

function getGameResults($id) {

    if ($id) {

        $db = DB::getConnection();

        $sql = "SELECT 
            t.name as name, 
            t.points as points, 
            t.position as position,
            g.name as game,
            g.description as description
            FROM teams as t
            LEFT JOIN games as g on t.gameId = g.id
            WHERE t.gameId = :id 
            AND position > 0
            ORDER BY position";
        
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();       
        $results = $result->fetchAll();

        if($results){
            return $results;
        }
    }
    return false;
}


/**
 * Достает игры из базы название по id
 * @param int $id row game id
 * @return string or false
 */
function getGameNameById ($id) {
    
    if ($id) {

        $db = DB::getConnection();
        $sql = "SELECT name FROM games WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $gameName = $result->fetchColumn();
        
        if($gameName){
            return $gameName;
        }
    }
    return false;
}

/**
 * Достает имя сезона из базы название по id
 * @param int $id 
 * @return string or false
 */


function getSeasonNameById ($id) {
    
    if ($id) {

        $db = DB::getConnection();
        $sql = "SELECT name FROM seasons WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $seasonName = $result->fetchColumn();
        
        if($seasonName){
            return $seasonName;
        }
    }
    return false;
}

/**
 * Достает лого сезона из базы по id
 * @param int $id 
 * @return string or false
 */


function getSeasonLogoById ($id) {
    
    if ($id) {

        $db = DB::getConnection();
        $sql = "SELECT season_logo FROM seasons WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $seasonName = $result->fetchColumn();
        
        if($seasonName){
            return $seasonName;
        }
    }
    return false;
}

/**
 * Достает игры из базы данные для отправки уведомления о регистарции
 * @param int $id gameid
 * @return array or false
 */

function getGameForMail ($id) {
    $db = DB::getConnection();
    
    $sql = "SELECT name, start_date FROM games WHERE id = :id";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();       
    $game = $result->fetch();
    
    if ($game) {
        return $game;
    }
    return false;
}

/**
 * Сохраняет в базу чувака и команду из формы регистрации
 * @params mixed 
 * @return bool
 */

function saveTeam ($team,$captain,$gamers,$tel,$email,$gameId, $team_token) {
    
    $db = DB::getConnection();
    
    $sql = 'INSERT INTO users (name, tel, email) VALUES (:captain, :tel, :email); 
            SET @lastID := LAST_INSERT_ID(); 
            INSERT INTO teams (name, captainID, gamers, gameId, team_token) VALUES (:team, @lastID, :gamers, :gameId, :team_token );';
    
    $result = $db->prepare($sql);
    $result->bindParam(':captain', $captain, PDO::PARAM_STR);
    $result->bindParam(':tel', $tel, PDO::PARAM_STR);
    $result->bindParam(':email', $email, PDO::PARAM_STR);
    $result->bindParam(':team', $team, PDO::PARAM_STR);
    $result->bindParam(':gamers', $gamers, PDO::PARAM_INT);
    $result->bindParam(':gameId', $gameId, PDO::PARAM_INT);
    $result->bindParam(':team_token', $team_token, PDO::PARAM_STR);
    
    if($result->execute()) {
        return true;
    }
    
    return false;
}

/**
 * Сохраняет в базу чувака из формы звонка
 * @param string $name, string $tel
 * @return bool
 */
function saveUser($name, $tel) {
    
    $db = DB::getConnection();
    
    $sql = 'INSERT INTO users (name, tel) VALUES (:name, :tel)';
    
    $result = $db->prepare($sql);
    $result->bindParam(':name', $name, PDO::PARAM_STR);
    $result->bindParam(':tel', $tel, PDO::PARAM_STR);
    
    if($result->execute()) {
        return true;
    }
    return false;
    
}

/**
 * Достает новости
 * @return array or false
 */

function getNews() {

        $db = DB::getConnection();

        $sql = "SELECT *
            FROM news
            ORDER BY date_add desc";
        
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();       
        $news = $result->fetchAll();

        if($news){
            return $news;
        }
        
    return false;
}

/**
 * Для конверсии рассылок, сколько раз ссылку дернули, столько записей
 * @param string $message, string $identifier
 * @return bool
 */
function setUserFromSmsLinkOuter($message, $identifier) {
    
    $db = DB::getConnection();
    
    $sql = 'INSERT INTO outer_links (message, identifier) VALUES (:message, :identifier)';
    
    $result = $db->prepare($sql);
    $result->bindParam(':message', $message, PDO::PARAM_STR);
    $result->bindParam(':identifier', $identifier, PDO::PARAM_STR);
    
    if($result->execute()) {
        return true;
    }
    return false;
    
}

/**
 * Получить ID команды по ее токену.
 * @param string $token 
 * @return int
 */

function getTeamIdByToken($token) {
    
    $db = DB::getConnection();
    
    $sql = 'SELECT id FROM teams WHERE team_token = :token';
    
    $result = $db->prepare($sql);
    $result->bindParam(':token', $token, PDO::PARAM_STR);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
            
    $teamId = $result->fetchColumn();
    
    if ($teamId) {
        return $teamId;
    }
          
    return false;
    
}

/**
 * Проверить регистрацию команды по токену и teamid
 * @param string $token , int $teamid
 * @return int
 */

function checkTeamRegistration($gameid, $teamid, $token) {

        $db = DB::getConnection();

        $sql = "SELECT *
            FROM teams
            WHERE id = :teamid AND
            gameId = :gameid AND
            team_token = :token
            LIMIT 1";
        
        $result = $db->prepare($sql);
        $result->bindParam(':teamid', $teamid, PDO::PARAM_INT);
        $result->bindParam(':gameid', $gameid, PDO::PARAM_INT);
        $result->bindParam(':token', $token, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
                
        if($result->fetch()) {
            return true;
        }       
        
        return false;
}


/**
 * Проверить ответ команды по токену и teamid
 * @param string $token , int $teamid
 * @return int
 */

function checkTeamAnswer($qstnum, $gameid, $teamid, $token) {

        $db = DB::getConnection();

        $sql = "SELECT *
            FROM additional_answers
            WHERE qst_number = :qstnum  AND
            gameId = :gameid      AND
            teamid = :teamid      AND
            team_token = :token   AND
            answer IS NOT NULL";
        
        $result = $db->prepare($sql);
        $result->bindParam(':qstnum', $qstnum, PDO::PARAM_INT);
        $result->bindParam(':teamid', $teamid, PDO::PARAM_INT);
        $result->bindParam(':gameid', $gameid, PDO::PARAM_INT);
        $result->bindParam(':token', $token, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
                
        if($result->fetch()) {
            return true;
        }       
        
        return false;
}

/**
 * Сохранить ответ команды по доп ссылки
 * @param int $qstid, int $gameid, int $teamid, string $team_token, int $answer
 * @return bool
 */
function saveAnswer($qstnum, $gameid, $teamid, $team_token, $answer) {
    
    $db = DB::getConnection();
    
    $sql = 'INSERT INTO additional_answers (qst_number, gameid, teamid, team_token, answer) '
            . 'VALUES (:qst_number, :gameid, :teamid, :team_token, :answer)';
    
    $result = $db->prepare($sql);
    $result->bindParam(':qst_number', $qstnum, PDO::PARAM_INT);
    $result->bindParam(':gameid', $gameid, PDO::PARAM_INT);
    $result->bindParam(':teamid', $teamid, PDO::PARAM_INT);
    $result->bindParam(':team_token', $team_token, PDO::PARAM_STR);
    $result->bindParam(':answer', $answer, PDO::PARAM_STR);
    
    if($result->execute()) {
        return true;
    }
    return false;
    
}

/**
 * Получить вопрос по номеру и gameid
 * @param int $qstnum, int $gameid
 * @return bool
 */
function getQuestionByGameid($qstnum, $gameid) {
    
    $db = DB::getConnection();
    
    $sql = "SELECT * FROM additional_questions 
            WHERE qst_number = :qstnum  AND 
            gameid = :gameid            AND
            active = 1 ";                 
    
    $result = $db->prepare($sql);
    $result->bindParam(':qstnum', $qstnum, PDO::PARAM_INT);
    $result->bindParam(':gameid', $gameid, PDO::PARAM_INT);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    
    $qst = $result->fetch();
    
    if($qst) {
        return $qst;
    }
    return false;
    
}

/**
 * Подготовка данных для рассылки ссылок
 * @param  int $gameid
 * @return array or false
 */
function getTeamsForLink($gameid) {
    
    $db = DB::getConnection();
    
    $sql = "SELECT t.name as team, u.name, u.email, t.id, t.team_token, t.date_add FROM teams as t 
            LEFT JOIN users as u ON t.captainID = u.id 
            WHERE t.gameId = :gameid";
    
    $result = $db->prepare($sql);
    $result->bindParam(':gameid', $gameid, PDO::PARAM_INT);
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $result->execute();
    
    $data = $result->fetchAll();
    
    if($data) {
        return $data;
    }
    return false;
    
}

/**
 * Достает команду из базы название по id
 * @param int $id 
 * @return string or false
 */

function getTeamNameById ($id) {
    
    if ($id) {

        $db = DB::getConnection();
        $sql = "SELECT name FROM teams WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $teamName = $result->fetchColumn();
        
        if($teamName){
            return $teamName;
        }
    }
    return false;
}


/**
 * Проверяет дубль команды при регистрации
 * @param int $gameid , str $teamName
 * @return bool
 */

function checkTeamNameRegistration ($teamName, $gameid) {

        $db = DB::getConnection();
        $sql = "SELECT name FROM teams WHERE name = :teamname AND gameid = :gameid ";
        $result = $db->prepare($sql);
        $result->bindParam(':teamname', $teamName, PDO::PARAM_STR);
        $result->bindParam(':gameid', $gameid, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        
        $res = $result->fetchColumn();
        
        if($res){
            return $res;
        }
    
    return false;
}

/**
 * Задание для крона, меняет активные игры
 * @param null
 * @return bool
 */

function setGameActiveNot() {
    
    $db = DB::getConnection();
    
    $sql = 'UPDATE games SET active = 0 WHERE start_date < now() AND active = 1';
    
    $result = $db->prepare($sql);
       
    if($result->execute()) {
        return true;
    }
    return false;
    
}


/**
 * Генерит отчет по доп ответам. Выборка по играм за текущий день.
 * @param NULL
 * @return string or false
 */
function getRepAnswers() {
    
        $db = DB::getConnection();
        
        $sql = "SELECT 	g.name as game , 
		DATE(g.start_date) as game_date, 
		t.name as team, 
		u.name as captain, 
		u.email as email, 
		aa.qst_number as qst_number, 
		aa.answer as answer,
		aa.date_add as answer_date
                FROM additional_answers as aa 
                LEFT JOIN games as g ON g.id = aa.gameid 
                LEFT JOIN teams as t ON t.id = aa.teamid 
                LEFT JOIN users as u ON u.id = t.captainID 
                WHERE aa.gameid in (SELECT id FROM games WHERE TO_DAYS(start_date) = TO_DAYS(now())) 
                order by t.name ";


        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $repData = $result->fetchAll();
        
        if($repData){
            return $repData;
        }
    
    return false;
}

