/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

import java.util.ArrayList;

/**
 *
 * @author Dark_MeFoDy
 */
public class Archive {
    static ArrayList<ArchiveField> archive = new ArrayList<ArchiveField>();
    
    public void AddField(ArchiveField af) {
        archive.add(af);
    }
}
