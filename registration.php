<table>
                <tr>
                    <td>
                        <form name="form_acc" action="" method="post">
                            <table>
                                <tr>
                                    <td>Account Username:</td>
                                    <td><input type="text" name="accUsername" autocomplete="off" required></td>
                                </tr>


                                <tr>
                                    <td>Account Password:</td>
                                    <td><input type="password" name="accPassword" autocomplete="off" required></td>
                                </tr>


                                <tr>
                                    <td>Confirm Password:</td>
                                    <td><input type="password" name="accPasswordConfirm" autocomplete="off" required></td>
                                </tr>


                                <tr>
                                    <td><input type ="submit" value="Submit" name="submitButton"></td>
                                </tr>
                            </table>
                        </form>
                    </td>
                    <td>
                        <article>
                            <?php
                                function checkform() { 
                                    if (isset ($_POST['accPassword']) && isset ($_POST['accPasswordConfirm']) && isset ($_POST['accUsername'])) {    
                                        $alert="normal";
                                        $e=0;
                                        echo "Make sure your information conforms to the following:<br><ul>";


                                        if (preg_match("/[^A-Za-z0-9]/",$_POST['accUsername'])) { $alert = "alert"; $e++; } else { $alert = "normal"; }
                                        echo "<li class=\"".$alert."\">Username can only contain 0-9, A-Z, and a-z.</li>";


                                        if (strlen($_POST['accUsername']) < 3 || strlen($_POST['accUsername']) > 12) { $alert = "alert"; $e++; } else { $alert = "normal"; }
                                        echo "<li class=\"".$alert."\">Username must be between 3 and 12 characters long.</li>";


                                        if (preg_match("/[^A-Za-z0-9]/",$_POST['accPassword'])) { $alert = "alert"; $e++; }     else { $alert = "normal"; }
                                        echo "<li class=\"".$alert."\">Password can only contain 0-9, A-Z, and a-z.</li>";
                                        
                                        if (strlen($_POST['accPassword']) < 8 || strlen($_POST['accPassword']) > 32) { $alert = "alert"; $e++; } else { $alert = "normal"; }
                                        echo "<li class=\"".$alert."\">Password must be between 8 and 32 characters long.</li>";
                                        


                                        if ($_POST['accPassword']!=$_POST['accPasswordConfirm']) { $alert = "alert"; $e++; } else { $alert = "normal"; }
                                        echo "<li class=\"".$alert."\">Both passwords must match.</li>";


                                        $db = MySQL::get();
                                        $accUsername = $_POST['accUsername'];
                                        $stmt = $db->prepare('SELECT COUNT(username) FROM account WHERE username = ?;');
                                        $stmt->bindParam(1, $accUsername, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 12);
                                        $stmt->bindParam(2, $accPassword, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
                                        $stmt->execute();
                                        $rows = $stmt->fetchColumn();
                                        if($rows>0) {
                                            $alert = "alert";
                                            $e++;
                                        } else {
                                            $alert = "normal";
                                        }
                                        echo "<li class=\"".$alert."\">Username must not already be in use.</li>";


                                        if ($e>0) {return false;} else {return true;}
                                    } else {
                                        echo "Make sure your information conforms to the following:<br><ul>";
                                        echo "<li class=\"normal\">Username can only contain 0-9, A-Z, a-z.</li>";
                                        echo "<li class=\"normal\">Username must be between 3 and 12 characters long.</li>";
                                        echo "<li class=\"normal\">Password can only contain 0-9, A-Z, a-z.</li>";
                                        echo "<li class=\"normal\">Password must be between 8 and 32 characters long.</li>";
                                        echo "<li class=\"normal\">Both passwords must match.</li>";
                                        echo "<li class=\"normal\">Username must not already be in use.</li>";
                                        return false;
                                    }
                                }


                                function register() {
                                    $db = MySQL::get();
                                    $accUsername = $_POST['accUsername'];
                                    $accPassword = $_POST['accPassword'];
                                    $stmt = $db->prepare('CALL create_account(?, ?)');
                                    $stmt->bindParam(1, $accUsername, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 12);
                                    $stmt->bindParam(2, $accPassword, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 32);
                                    $stmt->execute();
                                }


                                if(checkform()===true) { register();}
                            ?>
                        </article>
