(ns lab1.core
  (:gen-class)
  (use 'clojure.java.io))

;=============== CONSTANTS ==========
(def eBig 0.5)
(def eSmall 0.15)
(def rA 3)
(def rB (* rA 1.5))

;=============== METHODS ============

;---------------- FORMULA -----------
(defn alpha
  [r]
  (/ 4 (* r r)))

(defn exp-potential
  [x r]
  (Math/exp (- (* (alpha r) (* x x)))))


;-------------- DISTANCES -----------

(defn euclidian-distance
  "Euclidian Distance"
  [a b]
  (Math/sqrt (reduce + (map #(let [c (- %1 %2)] (* c c)) a b))))

(defn hamming-distance
  "Hamming Distance"
  [a b]
  (count (filter true? (map (partial reduce not=) (map vector a b)))))


;--------------- CALCULATE -----------

(defn read-from-file
  "Read points from file"
  [filename]
  (let [input (slurp filename)]
    (filterv not-empty
        (for [line (line-seq (java.io.BufferedReader. (java.io.StringReader. input)))]
             (vec (map read-string (re-seq #"[\d.]+" line)))))))

(defn convert-points
  [point]
  (reduce (fn [result point] (conj result {:coord point, :index (count result)})) [] point))

(defn calculate-potential
  [element elements method]
  (assoc element :potential (reduce #(+ %1 (exp-potential (method (:coord %2) (:coord element)) rA)) 0 elements)))

(defn calculate-potentials
  [elements method]
  (sort-by #(- (:potential %1))(map #(calculate-potential %1 elements method) elements)))


(defn revision-potential
  [center element method]
  (assoc element :potential (- (:potential element) (* (:potential center) (exp-potential (method (:coord center) (:coord element)) rB)))))

(defn revision-potentials
  [center elements method]
  (sort-by #(- (:potential %1))(map #(revision-potential center %1 method) elements)))

(defn dmin
  [point points method]
  (apply min (map #(method (:coord point) (:coord %1)) points)))


(defn clasterize-elements
  [elements method]
  (let [elements (calculate-potentials elements method)]
    ;(println elements)
    (loop [centers [(first elements)] elements (rest elements)]
      (let [elements (revision-potentials (last centers) elements method) newCenter (first elements)]
        ; 1st condition
        (if (< (* (:potential (first centers)) eBig) (:potential newCenter))
          (recur (conj centers newCenter) (rest elements))
          ; 2nd condition
          (if (> (* (:potential (first centers)) eSmall) (:potential newCenter))
            centers ; RETURN
            ; 3rd condition
            (if (>= (+ (/ (:potential newCenter) (:potential (first centers))) (/ (dmin newCenter centers method) rA)) 1)
              (recur (conj centers newCenter) (rest elements))
              (recur centers (conj (rest elements) (assoc newCenter :potential 0))))))))))

(defn clasterize
  [distance-method points]
  ;(println points)
  (let [elements (convert-points points)]
    (clasterize-elements elements distance-method)))



;====================== MAIN ===========
(defn -main
  "Main Function"
  [& args]
  (if (= (count args) 2)
    (let [points (read-from-file (first args))]
      (println (clasterize (if (= (last args) "h") hamming-distance euclidian-distance) points)))
    (println "Not enough parameters.\n\n",
             "Usage: lein run <filename> <distance>\n",
             "Params:\n",
             "   filename - set the file of input data with points\n",
             "   distance - [h|e]\n",
             "              h => Hamming Distance\n",
             "              e => Euclidian Distance (default)\n")))

;(-main "/Users/asd/Sites/poitlabs/9/FP/lab1/бабочка.txt" "h")
