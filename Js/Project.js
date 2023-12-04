// ADD PROJECT FORM //

const displayProject = document.getElementById("display-project")
const ProjectForm = document.getElementById('add-project-form');
const ProjectMessage = document.getElementById('subtitle');

// This async function fetches all the stored projects. When done, it displays each project inside our HTML table for
// each project there is

async function loadProjects (){ 
  try { 
    const response = await fetch('http://localhost/super-reminder/project/gp', {
  });
    if (!response.ok) {
      throw new Error('Network response was not OK');
    }
      const data = await response.json();

      if (data) {
        console.log(data)

        data.forEach((project, index) => {
          // For each new project, we add a row
        const newRow = document.createElement('tr');
          
        // Number each row
        const firstTd = document.createElement('td');
        firstTd.textContent = index + 1;
          
        // The second td contains the title
        const secondTd = document.createElement('td');
        secondTd.textContent = project.title;
          
        // The third td contains the description
        const thirdTd = document.createElement('td');
        thirdTd.textContent = project.description;
          
        // The fourth td contains the displayLink to open a project.
        const displayLinkTd = document.createElement('td');
        const displayLink = document.createElement("a");
        
        // This extra button is for the removal of the project, we also have to a form
        const deleteLinkTd = document.createElement('td');
        const deleteFormBtn = document.createElement("button");
        const deleteProjectForm = document.createElement("form")
        
        displayLink.href = `/super-reminder/project/v/${project.id}`;
        displayLink.textContent = 'Voir';
        displayLinkTd.appendChild(displayLink);

        deleteProjectForm.id = "delete-project-form"
        deleteProjectForm.action = `/super-reminder/project/d/${project.id}`;
        deleteFormBtn.textContent = 'Supprimer';
        deleteProjectForm.appendChild(deleteFormBtn);
        deleteLinkTd.appendChild(deleteProjectForm);

        const deleteProjectMessage = document.getElementById("delete-project-message")

        deleteProjectForm.addEventListener('submit', async (event) => {
          event.preventDefault()

          try { 
            const response = await fetch(`http://localhost/super-reminder/project/d/${project.id}`, {
              method: 'POST',
              body: new FormData(deleteProjectForm)
            });
            if (!response.ok) {
              throw new Error('Network response was not OK');
            }
              const data2 = await response.json();
              const message = data.message;
            if (data2.success) {
              console.log(data2)
              deleteProjectMessage.style.color = 'green';
              displayProject.innerHTML = '';
              loadProjects()
            } else {
              deleteProjectMessage.style.color = 'red';
            }
              deleteProjectMessage.textContent = message;
            }    
            catch (error) {
              console.error('Error:', error);
              deleteProjectMessage.textContent = 'Erreur survenue côté serveur.';
            }
        })


          
        // Append all tds to the new row
        newRow.appendChild(firstTd);
        newRow.appendChild(secondTd);
        newRow.appendChild(thirdTd);
        newRow.appendChild(displayLinkTd);
        newRow.appendChild(deleteLinkTd);
          
              // Append the new row to the table body
              const table = document.getElementById('display-project');
              table.appendChild(newRow);
        });  
      } else {
        console.log('echec')
      }
      }    
    catch (error) {
        console.error('Error:', error);
        ProjectMessage.textContent = 'Erreur survenue côté serveur.';
      }
      
}

// We call the function so that the table is displayed when we load the page

loadProjects();

ProjectMessage.style.color = 'red'

ProjectForm.addEventListener('submit', async (event) => {
    event.preventDefault();

    clearErrors(); // On vide la div qui affiche les messages
  
    if (!validateFields()) { // Si les champs sont remplis on effectue le fetch
      return;
    }
  
    try { 
        const response = await fetch('http://localhost/super-reminder/project/pa', {
          method: 'POST',
          body: new FormData(ProjectForm)
        });
        if (!response.ok) {
          throw new Error('Network response was not OK');
        }
          const data = await response.json();
          const message = data.message;
        if (data.success) {
          console.log(data)
          ProjectMessage.style.color = 'green';
          displayProject.innerHTML = '';
          loadProjects()
        } else {
          ProjectMessage.style.color = 'red';
        }
          ProjectMessage.textContent = message;
        }    
        catch (error) {
          console.error('Error:', error);
          ProjectMessage.textContent = 'Erreur survenue côté serveur.';
        }
    });

// Clearing the message 

function clearErrors() {
  ProjectMessage.textContent = '';
}

// Checking if the fields are filled

function validateFields() {
  const titleValue = document.getElementById('title').value;
  const descriptionValue = document.getElementById('description').value;

  if (titleValue === '' || descriptionValue === '') {
    ProjectMessage.textContent = 'Les champs doivent être remplis';
    return false;
  } else {
    ProjectMessage.textContent = '';
    return true;
  }
}


// DELETE FORM //

const deleteProjectForm = document.getElementById("delete-project-form")
