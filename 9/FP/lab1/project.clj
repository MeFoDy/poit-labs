(defproject lab1 "0.1.0-SNAPSHOT"
  :description "The 1st FP lab (Nikita Dubko)"
  :url "http://github.com/dark_mefody"
  :license {:name "Eclipse Public License"
            :url "http://www.eclipse.org/legal/epl-v10.html"}
  :dependencies [[org.clojure/clojure "1.6.0"]]
  :main ^:skip-aot lab1.core
  :target-path "target/%s"
  :profiles {:uberjar {:aot :all}})
