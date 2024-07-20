package mathchallenge;

import java.util.regex.Pattern;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.time.format.DateTimeParseException;

public class ParticipantValidator {

    public static String validate(Participant participant) {
        if (participant.getUsername() == null || participant.getUsername().isEmpty()) {
            return "Username is required.";
        }
        if (participant.getFirstname() == null || participant.getFirstname().isEmpty()) {
            return "Firstname is required.";
        }
        if (participant.getLastname() == null || participant.getLastname().isEmpty()) {
            return "Lastname is required.";
        }
        if (participant.getEmailAddress() != null
                && !Pattern.compile("^[a-zA-Z0-9_+&-]+(?:\\.[a-zA-Z0-9_+&-]+)*@(?:[a-zA-Z0-9-]+\\.)+[a-zA-Z]{2,7}$")
                        .matcher(participant.getEmailAddress()).matches()) {
            return "Invalid email address.";
        }
        if (participant.getDateOfBirth() != null) {
            DateTimeFormatter dateFormatter = DateTimeFormatter.ofPattern("dd-MM-yyyy");
            try {
                LocalDate.parse(participant.getDateOfBirth(), dateFormatter);
            } catch (DateTimeParseException e) {
                return "Invalid date of birth.";
            }
        }
        if (participant.getSchoolRegistrationNumber() == null || participant.getSchoolRegistrationNumber().isEmpty()) {
            return "School registration number is required.";
        }
        return "Participant is valid.";
    }
}
