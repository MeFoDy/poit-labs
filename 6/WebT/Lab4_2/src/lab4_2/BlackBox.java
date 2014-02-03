/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab4_2;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

/**
 *
 * @author Dark_MeFoDy
 */
public class BlackBox {
    private List<Double> box = new ArrayList<>();
    private int k = 0;
    
    public void add(Double x) {
        if (box.indexOf(x) == -1) {
            box.add(x);
        }
    }
    
    public Double getKElem(int k) {
        if (k < box.size() && k >= 0) {
            this.k = k;
            Collections.sort(box);
            return box.get(k);
        }
        else {
            return Double.NaN;
        }
    }
}
