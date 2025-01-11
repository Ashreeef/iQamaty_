// Function to handle form submission
// Function to handle form submission
document.getElementById('sport-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    try {
        const formData = new FormData(e.target);
        
        const response = await fetch('/iQamaty_10/app/Controllers/save_sport.php', {
            method: 'POST',
            body: formData // Don't set Content-Type header - browser will set it automatically with boundary
        });

        const result = await response.json();

        if (result.success) {
            alert('Sport added successfully!');
            e.target.reset(); // Reset the form
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add the sport. Please try again.');
    }
});

// Attach event listener to the form
// For the first PHP version that expects JSON
document.getElementById('sport-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const sportData = {
        SName: formData.get('sport-name'),
        SLocation: formData.get('sport-location'),
        SDescription: formData.get('sport-description'),
        isRegister: formData.get('sport-register') ? 1 : 0,
        SFormLink: formData.get('sport-link') || '',
        SPicture: '' // You'll need a different approach for handling files with JSON
    };

    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_sport.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(sportData)
        });

        const result = await response.json();

        if (result.success) {
            alert('Sport added successfully!');
            e.target.reset();
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add the sport. Please try again.');
    }
});



// Function to fetch sports from the database
const fetchSports = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/get_sport.php');
        const result = await response.json();

        if (result.success) {
            return result.data; // Return sports data
        } else {
            console.error('Failed to fetch sports:', result.message);
            return [];
        }
    } catch (error) {
        console.error('Error fetching sports:', error);
        return [];
    }
};

// Function to populate the sports dropdown
const populateSportsDropdown = async () => {
    const sports = await fetchSports();
    const sportsDropdown = document.getElementById('team-sport');

    sportsDropdown.innerHTML = '<option value="">Select a sport</option>'; // Default option

    sports.forEach(sport => {
        const option = document.createElement('option');
        option.value = sport.SportID;
        option.textContent = sport.SName;
        sportsDropdown.appendChild(option);
    });
};

// Function to save a new team
const saveTeam = async (teamData) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_team.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(teamData),
        });

        const result = await response.json();

        if (result.success) {
            alert('Team added successfully!');
            document.getElementById('add-team-form').reset(); // Reset the form
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add the team. Please try again.');
    }
};

// Event listener for the team form submission
document.getElementById('add-team-form').addEventListener('submit', (e) => {
    e.preventDefault();

    // Collect form data
    const teamData = {
        TName: document.getElementById('team-name').value,
        SportID: document.getElementById('team-sport').value,
    };

    // Save the team
    saveTeam(teamData);
});

// Populate sports dropdown on page load
document.addEventListener('DOMContentLoaded', populateSportsDropdown);



// Function to fetch existing sports
const fetchExistingSports = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/get_sport.php');
        const result = await response.json();

        if (result.success) {
            return result.data;
        } else {
            console.error('Failed to fetch sports:', result.message);
            return [];
        }
    } catch (error) {
        console.error('Error fetching sports:', error);
        return [];
    }
};

// Function to fetch existing teams
const fetchExistingTeams = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/get_teams.php');
        const result = await response.json();

        if (result.success) {
            return result.data;
        } else {
            console.error('Failed to fetch teams:', result.message);
            return [];
        }
    } catch (error) {
        console.error('Error fetching teams:', error);
        return [];
    }
};

// Function to populate sports table
const populateSportsTable = async () => {
    const sports = await fetchExistingSports();
    const tableBody = document.querySelector('.sports-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    sports.forEach(sport => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${sport.SName}</td>
            <td>${sport.SDescription}</td>
            <td>${sport.SFormLink}</td>
            <td>
                <button class="delete-btn" data-id="${sport.SportID}">Delete</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
};

// Function to populate teams table
const populateTeamsTable = async () => {
    const teams = await fetchExistingTeams();
    const tableBody = document.querySelector('.teams-table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    teams.forEach(team => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${team.TName}</td>
            <td>${team.SportName}</td>
            <td>
                <button class="delete-btn" data-id="${team.TeamID}">Delete</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
};

// Initialize the tables on page load
document.addEventListener('DOMContentLoaded', () => {
    populateSportsTable();
    populateTeamsTable();
});



// Function to populate the team dropdown in the Add Student to Team form
const populateTeamDropdown = async () => {
    try {
        const teams = await fetchExistingTeams(); // Fetch teams from the backend
        console.log("Teams fetched:", teams); // Debugging

        const teamDropdown = document.getElementById('team-select');
        if (!teamDropdown) {
            console.error("Team dropdown not found in the DOM.");
            return;
        }

        // Clear existing options
        teamDropdown.innerHTML = '<option value="">Select a team</option>';

        // Populate options
        teams.forEach(team => {
            const option = document.createElement('option');
            option.value = team.TeamID; // Use the unique TeamID as the value
            option.textContent = `${team.TName} (${team.SportName})`; // Display team name and sport
            teamDropdown.appendChild(option);
        });
    } catch (error) {
        console.error("Error populating team dropdown:", error);
    }
};

// Populate the team dropdown on page load
document.addEventListener('DOMContentLoaded', populateTeamDropdown);




// Function to save a student to a team
const saveStudentToTeam = async (formData) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_team_student.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData),
        });

        const result = await response.json();

        if (result.success) {
            alert('Student added to the team successfully!');
            document.getElementById('add-student-form').reset(); // Reset the form
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add the student to the team. Please try again.');
    }
};

// Event listener for the add student form submission
document.getElementById('add-student-form').addEventListener('submit', (e) => {
    e.preventDefault();

    // Collect form data
    const formData = {
        StudentID: document.getElementById('student-id').value,
        TeamID: document.getElementById('team-select').value,
    };

    // Save the student to the team
    saveStudentToTeam(formData);
});









// Function to fetch team members by TeamID
const fetchTeamMembers = async (teamID) => {
    try {
        console.log(`Fetching members for TeamID: ${teamID}`);
        const response = await fetch(`/iQamaty_10/app/Controllers/get_team_members.php?TeamID=${teamID}`);
        const result = await response.json();
        console.log("Fetch result:", result);

        if (result.success) {
            return result.data;
        } else {
            console.error('Failed to fetch team members:', result.message);
            return [];
        }
    } catch (error) {
        console.error('Error fetching team members:', error);
        return [];
    }
};

// Function to populate the team members table
const populateTeamMembersTable = async (teamID) => {
    
    const members = await fetchTeamMembers(teamID);
    console.log("Team Members Data:", members); // Debugging
    const tableBody = document.querySelector('.team-members-viewer .table-members tbody');

    tableBody.innerHTML = ''; // Clear existing rows

    members.forEach(member => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${member.StudentID}</td>
            <td>${member.StudentName}</td>
            <td>${member.TMDate}</td>
        `;

        tableBody.appendChild(row);
    });
};


// Event listener for team selection to populate members
document.getElementById('team-select-viewer').addEventListener('change', (e) => {
    const teamID = e.target.value;
    if (teamID) {
        populateTeamMembersTable(teamID);
    } else {
        // Clear the table if no team is selected
        const tableBody = document.querySelector('.team-members-viewer .table-members tbody');
        tableBody.innerHTML = '';
    }
});


// Function to populate the team selector dropdown
const populateTeamSelector = async () => {
    const teams = await fetchExistingTeams();
    const teamDropdown = document.getElementById('team-select-viewer');

    teamDropdown.innerHTML = '<option value="">Select a team</option>'; // Default option

    teams.forEach(team => {
        const option = document.createElement('option');
        option.value = team.TeamID;
        option.textContent = `${team.TName} (${team.SportName})`;
        teamDropdown.appendChild(option);
    });
};

// Populate the team selector on page load
document.addEventListener('DOMContentLoaded', populateTeamSelector);






// training sessions :::

// populate select team:

const populateTeamSelect = async () => {
    try {
        const teams = await fetchExistingTeams(); // Fetch teams from the backend
        console.log('Teams fetched:', teams); // Debugging response

        const teamDropdown = document.getElementById('team-select-session');
        if (!teamDropdown) {
            console.error("Team dropdown not found in the DOM.");
            return;
        }

        // Clear existing options and set default
        teamDropdown.innerHTML = '<option value="">Select Team</option>';

        // Dynamically populate the dropdown
        teams.forEach(team => {
            const option = document.createElement('option');
            option.value = team.TeamID;
            option.textContent = `${team.TName} (${team.SportName})`;
            teamDropdown.appendChild(option);
        });

        console.log('Team dropdown populated successfully.');
    } catch (error) {
        console.error('Error populating team dropdown:', error);
    }
    console.log(document.getElementById('team-select'));

};

// Call the function on page load
document.addEventListener('DOMContentLoaded', populateTeamSelect);


// Function to save a training session
const saveTrainingSession = async (sessionData) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/save_training_session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(sessionData),
        });

        const result = await response.json();

        if (result.success) {
            alert('Training session saved successfully!');
            document.getElementById('add-training-session-form').reset(); // Reset the form
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error saving training session:', error);
    }
};

// Attach event listener to the form
document.getElementById('add-training-session-form').addEventListener('submit', (e) => {
    e.preventDefault();

    // Collect form data
    const sessionData = {
        TeamID: document.getElementById('team-select-session').value,
        TSDay: document.getElementById('day-select').value,
        TSTime: document.getElementById('time-input').value,
        CoachName: document.getElementById('coach-name').value,
    };

    saveTrainingSession(sessionData);
});



// Function to fetch training sessions from the database
const fetchTrainingSessions = async () => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/get_training_session.php');
        const result = await response.json();

        if (result.success) {
            return result.data; // Return the fetched training sessions
        } else {
            console.error('Failed to fetch training sessions:', result.message);
            return [];
        }
    } catch (error) {
        console.error('Error fetching training sessions:', error);
        return [];
    }
};

// Function to populate the training sessions table
const populateTrainingSessionsTable = async () => {
    const trainingSessions = await fetchTrainingSessions();
    const tableBody = document.querySelector('.training-sessions-table tbody');
    
    tableBody.innerHTML = ''; // Clear existing rows

    trainingSessions.forEach(session => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${session.TName}</td>
            <td>${session.TSDay}</td>
            <td>${session.TSTime}</td>
            <td>${session.CoachName}</td>
            <td>
                <button class="delete-btn" data-id="${session.TeamID}">Delete</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
};

// Call the populate function on page load
document.addEventListener('DOMContentLoaded', populateTrainingSessionsTable);





// Deletions:
// Function to delete a sport
const deleteSport = async (sportID) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/delete_sport.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ SportID: sportID }),
        });

        const result = await response.json();

        if (result.success) {
            alert('Sport deleted successfully!');
            populateSportsTable(); // Refresh the table
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error deleting sport:', error);
    }
};

// Function to delete a team
const deleteTeam = async (teamID) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/delete_team.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ TeamID: teamID }),
        });

        const result = await response.json();

        if (result.success) {
            alert('Team deleted successfully!');
            populateTeamsTable(); // Refresh the table
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error deleting team:', error);
    }
};

// Attach event listeners for delete buttons in the sports table
document.querySelector('.sports-table').addEventListener('click', (e) => {
    if (e.target.classList.contains('delete-btn')) {
        const sportID = e.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this sport?')) {
            deleteSport(sportID);
        }
    }
});

// Attach event listeners for delete buttons in the teams table
document.querySelector('.teams-table').addEventListener('click', (e) => {
    if (e.target.classList.contains('delete-btn')) {
        const teamID = e.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this team?')) {
            deleteTeam(teamID);
        }
    }
});



// Deletion of training sessions:
// Function to delete a training session using TeamID
const deleteTrainingSession = async (teamID) => {
    try {
        const response = await fetch('/iQamaty_10/app/Controllers/delete_session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ TeamID: teamID }),  // Only pass TeamID
        });

        const result = await response.json();

        if (result.success) {
            alert('Training session(s) deleted successfully!');
            populateTrainingSessionsTable(); // Refresh the table
        } else {
            alert(`Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error deleting training session:', error);
    }
};

// Attach event listeners for delete buttons in the training sessions table
document.querySelector('.training-sessions-table').addEventListener('click', (e) => {
    if (e.target.classList.contains('delete-btn')) {
        const teamID = e.target.getAttribute('data-id');  // Get TeamID from data-id attribute

        if (confirm('Are you sure you want to delete all training sessions for this team?')) {
            deleteTrainingSession(teamID);  // Pass only TeamID to delete sessions
        }
    }
});

