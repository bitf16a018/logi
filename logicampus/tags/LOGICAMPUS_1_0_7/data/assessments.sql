--Edna's first test for English 1401

INSERT INTO `assessment` (`assessment_id`, `display_name`, `class_id`, `date_available`, `date_unavailable`, `mail_responses`, `auto_publish`, `num_retries`, `minute_limit`, `description`, `instructions`, `show_result_type`, `possible_points`) VALUES (1, 'English Test 1', 2, NULL, NULL, 0, 0, NULL, NULL, 'This is a dummy test to run unit tests against.  Test will be worth 50 points.', '', 0, 25);
        

INSERT INTO `assessment_question` (`assessment_question_id`, `assessment_id`, `question_type`, `question_sort`, `question_points`, `question_display`, `question_text`, `question_choices`, `question_input`, `file_hash`) VALUES (1, 1, 2, 255, 5, 'Multiple Choice', 'Select the following person who was known as a poet.', 'YTo0OntpOjA7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjU6IkhvbWVyIjtzOjc6ImNvcnJlY3QiO2I6MTt9aToxO086MTY6IkFzc2Vzc21lbnRDaG9pY2UiOjQ6e3M6NDoicmFuayI7TjtzOjU6Im90aGVyIjtiOjA7czo1OiJsYWJlbCI7czoyOiJNbyI7czo3OiJjb3JyZWN0IjtiOjA7fWk6MjtPOjE2OiJBc3Nlc3NtZW50Q2hvaWNlIjo0OntzOjQ6InJhbmsiO047czo1OiJvdGhlciI7YjowO3M6NToibGFiZWwiO3M6NjoiQmFybmV5IjtzOjc6ImNvcnJlY3QiO2I6MDt9aTozO086MTY6IkFzc2Vzc21lbnRDaG9pY2UiOjQ6e3M6NDoicmFuayI7TjtzOjU6Im90aGVyIjtiOjA7czo1OiJsYWJlbCI7czoyOiJBbCI7czo3OiJjb3JyZWN0IjtiOjA7fX0=', 'TzoyMDoiQXNzZXNzbWVudElucHV0UmFkaW8iOjM6e3M6NToibGFiZWwiO047czo4OiJxdWVzdGlvbiI7TjtzOjEzOiJhbGxvd011bHRpcGxlIjtiOjA7fQ==', '');
INSERT INTO `assessment_question` (`assessment_question_id`, `assessment_id`, `question_type`, `question_sort`, `question_points`, `question_display`, `question_text`, `question_choices`, `question_input`, `file_hash`) VALUES (2, 1, 3, 255, 5, 'Multiple Answer', 'Click all the answers that are labeled "correct".', 'YTo1OntpOjA7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjc6ImNvcnJlY3QiO3M6NzoiY29ycmVjdCI7YjoxO31pOjE7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjU6Indyb25nIjtzOjc6ImNvcnJlY3QiO2I6MDt9aToyO086MTY6IkFzc2Vzc21lbnRDaG9pY2UiOjQ6e3M6NDoicmFuayI7TjtzOjU6Im90aGVyIjtiOjA7czo1OiJsYWJlbCI7czo3OiJjb3JyZWN0IjtzOjc6ImNvcnJlY3QiO2I6MTt9aTozO086MTY6IkFzc2Vzc21lbnRDaG9pY2UiOjQ6e3M6NDoicmFuayI7TjtzOjU6Im90aGVyIjtiOjA7czo1OiJsYWJlbCI7czo1OiJ3cm9uZyI7czo3OiJjb3JyZWN0IjtiOjA7fWk6NDtPOjE2OiJBc3Nlc3NtZW50Q2hvaWNlIjo0OntzOjQ6InJhbmsiO047czo1OiJvdGhlciI7YjowO3M6NToibGFiZWwiO3M6NToid3JvbmciO3M6NzoiY29ycmVjdCI7YjowO319', 'TzoyMzoiQXNzZXNzbWVudElucHV0Q2hlY2tib3giOjM6e3M6NToibGFiZWwiO047czo4OiJxdWVzdGlvbiI7TjtzOjEzOiJhbGxvd011bHRpcGxlIjtiOjA7fQ==', '');
INSERT INTO `assessment_question` (`assessment_question_id`, `assessment_id`, `question_type`, `question_sort`, `question_points`, `question_display`, `question_text`, `question_choices`, `question_input`, `file_hash`) VALUES (3, 1, 4, 255, 5, 'Matching', 'Match the Arabic numeral to the Roman numeral.', 'YTo2OntpOjA7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjE6IjEiO3M6NzoiY29ycmVjdCI7czoxOiJJIjt9aToxO086MTY6IkFzc2Vzc21lbnRDaG9pY2UiOjQ6e3M6NDoicmFuayI7TjtzOjU6Im90aGVyIjtiOjA7czo1OiJsYWJlbCI7czoxOiIyIjtzOjc6ImNvcnJlY3QiO3M6MjoiSUkiO31pOjI7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjE6IjMiO3M6NzoiY29ycmVjdCI7czozOiJJSUkiO31pOjM7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjE6IjQiO3M6NzoiY29ycmVjdCI7czoyOiJJViI7fWk6NDtPOjE2OiJBc3Nlc3NtZW50Q2hvaWNlIjo0OntzOjQ6InJhbmsiO047czo1OiJvdGhlciI7YjowO3M6NToibGFiZWwiO3M6MToiNSI7czo3OiJjb3JyZWN0IjtzOjE6IlYiO31zOjEzOiJyYW5kb21BbnN3ZXJzIjthOjU6e2k6MDthOjE6e2k6NDtzOjE6IlYiO31pOjE7YToxOntpOjA7czoxOiJJIjt9aToyO2E6MTp7aTozO3M6MjoiSVYiO31pOjM7YToxOntpOjE7czoyOiJJSSI7fWk6NDthOjE6e2k6MjtzOjM6IklJSSI7fX19', 'TzoyMzoiQXNzZXNzbWVudElucHV0TWF0Y2hpbmciOjM6e3M6NToibGFiZWwiO047czo4OiJxdWVzdGlvbiI7TjtzOjEzOiJhbGxvd011bHRpcGxlIjtiOjA7fQ==', '');
INSERT INTO `assessment_question` (`assessment_question_id`, `assessment_id`, `question_type`, `question_sort`, `question_points`, `question_display`, `question_text`, `question_choices`, `question_input`, `file_hash`) VALUES (4, 1, 1, 255, 5, 'True/False', 'Select "False".', 'YToyOntpOjA7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjQ6IlRydWUiO3M6NzoiY29ycmVjdCI7YjowO31pOjE7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjU6IkZhbHNlIjtzOjc6ImNvcnJlY3QiO2I6MTt9fQ==', 'TzoyMDoiQXNzZXNzbWVudElucHV0UmFkaW8iOjM6e3M6NToibGFiZWwiO047czo4OiJxdWVzdGlvbiI7TjtzOjEzOiJhbGxvd011bHRpcGxlIjtiOjA7fQ==', '');
INSERT INTO `assessment_question` (`assessment_question_id`, `assessment_id`, `question_type`, `question_sort`, `question_points`, `question_display`, `question_text`, `question_choices`, `question_input`, `file_hash`) VALUES (5, 1, 5, 255, 5, 'Fill in the Blank', 'Type in the word "Springfield".', 'YToyOntpOjA7TzoxNjoiQXNzZXNzbWVudENob2ljZSI6NDp7czo0OiJyYW5rIjtOO3M6NToib3RoZXIiO2I6MDtzOjU6ImxhYmVsIjtzOjExOiJTcHJpbmdmaWVsZCI7czo3OiJjb3JyZWN0IjtiOjE7fWk6MTtPOjE2OiJBc3Nlc3NtZW50Q2hvaWNlIjo0OntzOjQ6InJhbmsiO047czo1OiJvdGhlciI7YjowO3M6NToibGFiZWwiO3M6MTE6IlNwcmluZ2ZlaWxkIjtzOjc6ImNvcnJlY3QiO2I6MTt9fQ==', 'TzoxOToiQXNzZXNzbWVudElucHV0VGV4dCI6Mzp7czo1OiJsYWJlbCI7TjtzOjg6InF1ZXN0aW9uIjtOO3M6MTM6ImFsbG93TXVsdGlwbGUiO2I6MDt9', '');
 