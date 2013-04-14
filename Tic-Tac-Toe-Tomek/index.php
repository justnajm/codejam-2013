<html><head></head><body>
        <?php
        function printWinner($player = "X") {
            global $case;

            switch ($player) {
                case "empty":
                    echo "Case #{$case}: Game has not completed" . "<br>";
                    break;
                case "draw":
                    echo "Case #{$case}: Draw" . "<br>";
                    break;
                default:
                    echo "Case #{$case}: {$player} won" . "<br>";
                    break;
            }
        }

        function printAnswer($gameSquares) {
            $xRow = array(0, 0, 0, 0);  //row1, row2, row3, row4
            $oRow = array(0, 0, 0, 0);

            $xCol = array(0, 0, 0, 0);  //col1, col2, col3, col4
            $oCol = array(0, 0, 0, 0);

            $xCross = array(0, 0);       //Left Cross, Right Cross
            $oCross = array(0, 0);

            for ($i = 0; $i < count($gameSquares); $i++) {
                for ($j = 0; $j < strlen($gameSquares[$i]); $j++) {
                    $player = $gameSquares[$i][$j];             // pointer current character
                    // check horizontal row match
                    if ($player == "X") {
                        $xRow[$i]++;
                    } else if ($player == "O") {
                        $oRow[$i]++;
                    } else if ($player == "T") {
                        $xRow[$i]++;
                        $oRow[$i]++;
                    } else {
                        $empty++;
                    }
                    // check vertical column match
                    if ($player == "X") {
                        $xCol[$j]++;
                    } else if ($player == "O") {
                        $oCol[$j]++;
                    } else if ($player == "T") {
                        $xCol[$j]++;
                        $oCol[$j]++;
                    }
                }
                // check in the middle of loop, if any horizontal match found
                if ($xRow[$i] == 4 || $oRow[$i] == 4) {
                    break;
                }
                
                // check Left cross match
                $player = $gameSquares[$i][$i];
                if ($player == "X") {
                    $xCross[0]++;
                } else if ($player == "O") {
                    $oCross[0]++;
                } else if ($player == "T") {
                    $xCross[0]++;
                    $oCross[0]++;
                }
                // check Right cross match
                $player = $gameSquares[$i][(3 - $i)];
                if ($player == "X") {
                    $xCross[1]++;
                } else if ($player == "O") {
                    $oCross[1]++;
                } else if ($player == "T") {
                    $xCross[1]++;
                    $oCross[1]++;
                }
            }
            
            if (in_array(4, $xRow) || in_array(4, $xCol) || in_array(4, $xCross)) {
                printWinner("X");
            } else if (in_array(4, $oRow) || in_array(4, $oCol) || in_array(4, $oCross)) {
                printWinner("O");
            } else if($empty==0){
                printWinner("draw");
            } else {
                printWinner("empty");
            }
        }

        $file = file_get_contents("A-large.in");
        //$file = file_get_contents("mySample.in");
        $ar = explode("\n", $file);
        $case = 0;
        $gameSquares = array();
        for ($i = 1; $i < count($ar); $i++) {
            
            if(strlen($ar[$i])>1) $gameSquares[] = $ar[$i];
            
            if (count($gameSquares) == 4) {
                $case++;
                printAnswer($gameSquares);
                unset($gameSquares);
            }
        }
        ?>
    </body></html>