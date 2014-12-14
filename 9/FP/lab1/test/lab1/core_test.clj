(ns lab1.core-test
  (:require [clojure.test :refer :all]
            [lab1.core :refer :all]))

(deftest a-test
  (testing "FIXME, I fail."
    (is (= 1 1))))


(deftest alpha-test
  (testing "Alpha is incorrect"
    (is (= (alpha 2) 1))
    (is (= (alpha 1) 4))))

(deftest euclidian-distance-test
  (testing "Euclidian Distance is incorrect"
    (is (= (euclidian-distance [0 0] [3 4]) 5.0))
    (is (= (euclidian-distance [0 3 4] [0 0 0]) 5.0))))

(deftest hamming-distance-test
  (testing "Hamming Distance is incorrect"
    (is (= (hamming-distance [0 1 2 3] [0 1 2 3]) 0))
    (is (= (hamming-distance [0 1 2 3] [3 2 1 0]) 4))))

(deftest read-from-file-test
  (testing "Reading From File failure"
    (is (= (read-from-file "/dev/null") []))
    (is (= (read-from-file "test/lab1/read-from-file-test.txt") [[1 2 3] [4 5 6]]))))

(deftest convert-points-test
  (testing "Convert Points to Elements"
    (is (= (convert-points [[1 1][2 2]]) [{:coord [1 1] :index 0} {:coord [2 2] :index 1}]))
    (is (= (convert-points []) []))))

(deftest dmin-test
  (testing "Find minimal distance between points"
    (is (= (dmin {:coord [0 0]} [{:coord [1 1]} {:coord [1 0]}] euclidian-distance) 1.0))
    (is (= (dmin {:coord [0 0]} [{:coord [1 1]} {:coord [1 0]}] hamming-distance) 1))))
