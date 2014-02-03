package newpackage;

import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class TextFileParser {

    private static String filePath;
    private static int maxCount;

    public MailInfo Parse(String filePath, String slicePattern, String matchPattern) {
        ArrayList<MailInfo> poems = new ArrayList<MailInfo>();
        BufferedReader input = null;
        try {
            input = new BufferedReader(new FileReader(filePath));
        } catch (FileNotFoundException e) {
            System.out.println("File \"" + filePath + "\" not found");
            return null;
        }
        String tmp;
        MailInfo currentPoem = new MailInfo();
        try {
            String EMAIL_PATTERN =
                    "^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"
                    + "[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";
            Pattern pattern = Pattern.compile(EMAIL_PATTERN);
            while ((tmp = input.readLine()) != null) {
                Matcher matcher = pattern.matcher(tmp);
                if (matcher.matches()) {
                    currentPoem.list.add(tmp);
                    currentPoem.setNumber(currentPoem.getNumber() + 1);
                    System.out.println(currentPoem.getNumber());
                }
            }
            input.close();
        } catch (IOException ex) {
        }
        return currentPoem;
//        poems.add(currentPoem);
//        MailInfo result = new MailInfo();
//        for (MailInfo temp : poems) {
//            if (temp.getNumberOfExclamatorySentences() > result.getNumberOfExclamatorySentences()) {
//                result = temp;
//            }
//        }
//        result.setFileName(filePath);
//        return result;

    }
}
