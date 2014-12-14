(ns lab2.core-test
  (:require [clojure.test :refer :all]
            [lab2.core :refer :all]
            [net.cgrand.enlive-html :as html]))


(deftest fetch-url-test
  (testing "404 page-not-found"
    (let [result (fetch-url "http://googleasjdioansjdoan.com")]
      (is (= (:status result) 404)))))

(deftest parse-html-test
  (testing
    "Parsing HTML"
    (let [content (html/html-snippet (slurp "test.html"))
          links (get-urls content)]
      (is (= (count links) 7)))))

(deftest a-test
  (testing
    "FIXME, I fail."
    (is (= 1 1))))

(deftest redirect-detection-test
  (testing
    "Redirect"
    (is (= true (has-redirect {:status 300})))
    (is (= false (has-redirect {:status 310})))))

(deftest get-links-from-file-test
  (testing
    "Get data from file"
    (is (= 3 (count (get-links-from-file "links.txt"))))))
