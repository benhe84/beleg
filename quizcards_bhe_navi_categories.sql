UPDATE quizcards.bhe_navi_categories SET Kategorie = 'Schüler', login = 1, admin = 1, logout = 0, link = 'student_show.php' WHERE ID = 1;
UPDATE quizcards.bhe_navi_categories SET Kategorie = 'Fragen', login = 1, admin = 1, logout = 0, link = 'question_show.php' WHERE ID = 2;
UPDATE quizcards.bhe_navi_categories SET Kategorie = 'Wissen', login = 1, admin = 0, logout = 0, link = 'knowledge.php' WHERE ID = 3;
UPDATE quizcards.bhe_navi_categories SET Kategorie = 'Quiz', login = 1, admin = 1, logout = 0, link = 'quiz.php' WHERE ID = 4;
UPDATE quizcards.bhe_navi_categories SET Kategorie = 'Logout', login = 1, admin = 0, logout = 0, link = 'logout.php' WHERE ID = 5;
UPDATE quizcards.bhe_navi_categories SET Kategorie = 'Registrieren', login = 0, admin = 0, logout = 1, link = 'student_add.php' WHERE ID = 6;