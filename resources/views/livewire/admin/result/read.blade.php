
<div class="container">
    <h1>Analytics Dashboard</h1>



    <h2>School Rankings</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>School</th>
                <th>Average Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schoolRankings as $index => $school)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $school->school }}</td>
                    <td>{{ $school->average_marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Performance Over the Years</h2>
    <h3>Schools</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Year</th>
                <th>School</th>
                <th>Average Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performanceData['schoolPerformance'] as $index => $performance)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $performance->year }}</td>
                    <td>{{ $performance->school }}</td>
                    <td>{{ $performance->average_marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Participants</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Year</th>
                <th>Participant</th>
                <th>Average Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performanceData['participantPerformance'] as $index => $performance)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $performance->year }}</td>
                    <td>{{ $performance->participant }}</td>
                    <td>{{ $performance->average_marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <h2>Worst Performing Schools for a Challenge</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>School</th>
                <th>Average Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($worstSchools as $index => $school)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $school->school }}</td>
                    <td>{{ $school->average_marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Best Performing Schools</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>School</th>
                <th>Average Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bestSchools as $index => $school)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $school->school }}</td>
                    <td>{{ $school->average_marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Participants with Incomplete Challenges</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Participant</th>
                <th>Challenge</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incompleteParticipants as $index => $participant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $participant->participant }}</td>
                    <td>{{ $participant->challenge }}</td>
                    <td>{{ $participant->marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Percentage Repetition for a Participant</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Question</th>
                <th>Repetition Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($repetitionData as $index => $repetition)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $repetition['question'] }}</td>
                    <td>{{ number_format($repetition['percentage'], 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Fastest Participants</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Participant</th>
                <th>Challenge</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fastestParticipants as $index => $participant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $participant->participant }}</td>
                    <td>{{ $participant->challenge }}</td>
                    <td>{{ $participant->totalTime }} seconds</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>The Most Correctly Answered Questions</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Question</th>
                <th>Times Answered Correctly</th>
            </tr>
        </thead>
        <tbody>
            @foreach($correctQuestions as $index => $question)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $question->questions }}</td>
                    <td>{{ $question->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

