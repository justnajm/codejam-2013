<html><head></head><body>
        <?php
        /**
         * Print given value from one edge to other of an array
         * 
         * @global Integer $n
         * @global Integer $m
         * @param String $printVal
         * @param Array $drawAr
         * @param Int $startI
         * @param Int $startJ
         * @return Array
         */
        function printValTillEdge($printVal, $drawAr, $startI, $startJ) {
            global $n, $m;
            // print particular column from top to column bottom
            if ($startI===true) {
                for ($i = 0; $i < $n; $i++) {
                    $drawAr[$i][$startJ] = $printVal;
                }
            // print particular row from left to row right
            } else if ($startJ===true) {
                for ($j = 0; $j < $m; $j++) {
                    $drawAr[$startI][$j] = $printVal;
                }
            }
            return $drawAr;
        }

        function printAnswer($gameSquares) {
            global $n, $m, $maxVals;
            
            $drawSquares = array();// test lawn map with given design to test posibility
            // if lawn is single row/column, it is possible
            if ($n <= 1 || $m <= 1) {
                // it is possible to cut the lawn in likewise map
                return true;
            }
            // cut the grass from big value to small
            for ($p = 0; $p < count($maxVals); $p++) {
                // lawn rows
                for ($i = 0; $i < $n; $i++) {
                    // lawn cols
                    for ($j = 0; $j < $m; $j++) {
                        
                        if ($p == 0) {// cut the grass with maximum value given, on first move
                            $drawSquares[$i][$j] = $maxVals[$p];
                        } else if ($p > 0) { // cut the grass from maximum to minimum height
                            $mapVal = $gameSquares[$i][$j];
                            $drawVal = $drawSquares[$i][$j];
                            // check if grass needs to be trimmed or already set
                            if ($mapVal != $drawVal) {
                                // check particular column edge to edge grass height else try using row edge move
                                for ($newI = 0; $newI < $n; $newI++) {
                                    if ($gameSquares[$newI][$j] > $maxVals[$p]) {
                                        $continueUsingI = false;
                                        break;
                                    } else {
                                        $continueUsingI = true;
                                    }
                                }
                                if ($continueUsingI) {
                                    // start cutting in column
                                    $drawSquares = printValTillEdge($maxVals[$p], $drawSquares, true, $j);
                                } else {
                                    // check particular row edge to edge grass height else lawn design fails
                                    for ($newJ = 0; $newJ < $m; $newJ++) {
                                        if ($gameSquares[$i][$newJ] > $maxVals[$p]) {
                                            $continueUsingJ = false;
                                            break;
                                        } else {
                                            $continueUsingJ = true;
                                        }
                                    }
                                    
                                    if ($continueUsingJ) {
                                        // start cutting in row
                                        $drawSquares = printValTillEdge($maxVals[$p], $drawSquares, $i, true);
                                    } else {
                                        // not possible to adopt the design
                                        return false;
                                    }
                                }

                            }
                        }
                    }
                }
            }
            return true;
        }

        $file = file_get_contents("B-large.in");
        //$file = file_get_contents("mySample.in");
        $ar = explode("\n", $file);
        $case = 0;
        $gameSquares = array();
        $measure = array();
        //echo count($ar);
        //var_dump($ar);
        for ($i = 1; $i < count($ar); $i++) {
            if(strlen($ar[$i])>1){

                $measure = explode(" ",$ar[$i]);

                $n = $measure[0];
                $m = $measure[1];

                $maxVals = array();
                $tempAr = array();
                for ($j = 1; $j <= $n; $j++) {
//                    echo $ar[$i + 1] . "<br>";
                    $gameSquares[] = $tempAr = explode(" ", $ar[$i + 1]);
                    $tempAr = array_unique($tempAr);
                    $maxVals = array_merge($maxVals, $tempAr);

                    $i++;
                }

                if (count($gameSquares) == $n) {
                    $maxVals = array_unique($maxVals);
                    rsort($maxVals);
                    $case++;
                    $yes = printAnswer($gameSquares);
                    echo "Case #{$case}: " . ($yes ? "YES" : "NO") . "<br>";

                    unset($gameSquares);
                }
            }
        }
        //var_dump($gameSquares);
        ?>
    </body></html>