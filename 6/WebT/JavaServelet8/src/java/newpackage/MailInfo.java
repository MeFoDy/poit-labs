/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package newpackage;

import java.util.LinkedList;
import java.util.List;

/**
 *
 * @author HP
 */
public class MailInfo {
    private int number;
    private int numberOfExclamatorySentences;
    private String fileName;
    
    public List<String> list = new LinkedList<String>();

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }

    public String getFileName() {
        return fileName;
    }

    public void setNumber(int number) {
        this.number = number;
    }

    public void setNumberOfExclamatorySentences(int numberOfExclamatorySentences) {
        this.numberOfExclamatorySentences = numberOfExclamatorySentences;
    }

    public int getNumber() {
        return number;
    }

    public int getNumberOfExclamatorySentences() {
        return numberOfExclamatorySentences;
    }
   
    
    @Override
    public String toString(){
        return fileName+";"+number+";"+numberOfExclamatorySentences;
    }
    
}
