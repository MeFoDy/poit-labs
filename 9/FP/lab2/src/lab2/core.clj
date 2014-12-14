(ns lab2.core
  (:gen-class)
  (:require [clj-http.client :as client])
  (:require [net.cgrand.enlive-html :as html])
  (:use clojure.java.io))


;========= FORMAT ==============================================================
;========= {:id :link :parent :children :linked :depth :status :redirect} ======

;========= OUTPUT
;url1 10 links
;	   url11 bad
;	   url12 15 redirect url13
;url2 bad
;================


(defn parse-int
  [s]
  (Integer/parseInt (re-find #"\A-?\d+" s)))

(defn not-nil?
  [x]
  (not (nil? x)))


(defn get-urls
  [content]
  (filter not-nil? (map #(:href (:attrs %1)) (html/select content #{[:a]}))))


(defn fetch-url
  [url]
  (try
    (client/get url)
    (catch Exception e {:status 404 :headers nil})))


(defn is-html
  [content]
  (and (not= 404 (:status content)) (boolean (re-find #"text/html" (:content-type (:headers content))))))


(defn has-redirect
  [content]
  (boolean (some #(= (:status content) %) '(300 301 302 303 307))))

(defn parse-linked-page
  [parent url depth]
  (let [content (fetch-url url)
        child   {:id (str (java.util.UUID/randomUUID))
                 :parent (if (nil? parent) nil (:id parent))
                 :linked (if (is-html content) (get-urls (html/html-snippet (:body content))) '())
                 :depth depth
                 :link url
                 :status (:status content)
                 :children (atom [])
                 :redirect (if (has-redirect content) (:redirect (:headers content)) nil)}
        ]
        (swap! (:children parent) conj child)
        child))


(defn parse
  [element depth]
  (if (= depth 0)
    element
    (doseq [child (pmap #(parse-linked-page element %1 depth) (:linked element))]
      (parse child (- depth 1)))))


(defn get-links-from-file
  [filename]
  (with-open [rdr (reader filename)]
    (let [links (line-seq rdr)]
      (doall (filter not-nil? links)))))


(defn crawl
  [filename depth]
  (let [links (get-links-from-file filename)
        wrapper  {:id (str (java.util.UUID/randomUUID))
                 :parent nil
                 :linked links
                 :depth depth
                 :link "LAB2"
                 :status nil
                 :children (atom [])
                 :redirect nil}]
    (parse wrapper depth)
    wrapper)
  )



(defn element-stat
  [element]
  (str (:link element)
       (if (= (:status element) 404)
        " bad"
        (str " " (count (:linked element)) " links" (if (not-nil? (:redirect element)) " redirects " (:redirect element))))))


(defn print-current
  [element depth]
  (println (str (apply str (repeat depth "\t")) (element-stat element))))



(defn print-result
  [element depth]
  (print-current element depth)
  (doseq [child @(:children element)] (print-result child (+ depth 1))))


(defn -main
  [& args]
  (if (= (count args) 2)
    (let [wrapper (crawl (first args) (parse-int (last args)))]
      (print-result wrapper 0))
    (println "Not enough parameters.\n\n",
             "Usage: lein run <filename> <depth>\n",
             "Params:\n",
             "   filename - set the file of input data with url(s)\n",
             "   depth - number of iterations")))


;(-main "links.txt" 2)
