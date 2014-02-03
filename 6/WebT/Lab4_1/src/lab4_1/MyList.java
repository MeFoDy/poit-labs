/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab4_1;

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author Dark_MeFoDy
 */
public class MyList {
    private List<Double> box = new ArrayList<>();
    
    public void add(Double x) {
        if (box.indexOf(x) == -1) {
            box.add(x);
        }
    }
    
    public void remove(Double x) {
        if (box.indexOf(x) == -1) {
            box.remove(x);
        }
    }
    
    public Double getNearest(Double z) {
        if (box.isEmpty()) {
            return Double.NaN;
        }
        else {
            Double minDifference = Double.MAX_VALUE;
            Double res = box.get(0);
            for (Double y : box) {
                if (Math.abs(y - z) < minDifference) {
                    minDifference = Math.abs(y - z);
                    res = y;
                }
            }
            return res;
        }
    }
}
