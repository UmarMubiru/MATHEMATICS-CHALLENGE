package mathchallenge;

public class Participant {
    private String username;
    private String firstname;
    private String lastname;
    private String emailAddress;
    private String dateOfBirth;
    private String schoolRegistrationNumber;
    private String imageFile;

    public Participant(String username, String firstname, String lastname, String emailAddress, String dateOfBirth, String schoolRegistrationNumber, String imageFile) {
        this.username = username;
        this.firstname = firstname;
        this.lastname = lastname;
        this.emailAddress = emailAddress;
        this.dateOfBirth = dateOfBirth;
        this.schoolRegistrationNumber = schoolRegistrationNumber;
        this.imageFile = imageFile;
    }

    public String getUsername() {
        return username;
    }

    public String getFirstname() {
        return firstname;
    }

    public String getLastname() {
        return lastname;
    }

    public String getEmailAddress() {
        return emailAddress;
    }

    public String getDateOfBirth() {
        return dateOfBirth;
    }

    public String getSchoolRegistrationNumber() {
        return schoolRegistrationNumber;
    }

    public String getImageFile() {
        return imageFile;
    }
}
