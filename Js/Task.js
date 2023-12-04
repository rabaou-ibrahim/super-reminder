// FETCH TODO TASKS //

const addTaskForm = document.getElementById('task-form-add');
const addTaskMessage = document.getElementById('add-task-subtitle');
const idProject = document.getElementById('id-project').value;
const ulTodo = document.getElementById("ul-todo");
const ulProgress = document.getElementById("ul-progress");
const ulDone = document.getElementById("ul-done");

addTaskMessage.style.color = 'red'

// Retrieving the tasks data at the start


// This async function fetches all the stored todo tasks. When done, it displays each project inside our HTML for
// each todo task there is

async function loadToDoTasks (){
  try {
    const response = await fetch(`http://localhost/super-reminder/task/gtt/${idProject}`);
    if (!response.ok) {
      throw new Error('Network response was not OK');
    }
    const data = await response.json();

    if (data) {
    
      for (let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        li.id = "todo-list";
    
        const titlePara = document.createElement("p");
        titlePara.id = "task-title-p-todo";
        titlePara.textContent = data[i].title;
    
        const descriptionSpan = document.createElement("span");
        descriptionSpan.id = "task-description-span-todo";
        descriptionSpan.textContent = data[i].description;
    
        // Create the buttons and line elements
        const blockButtonsDiv = document.createElement("div");
        blockButtonsDiv.id = "block-buttons";
    
        const blueButton = document.createElement("button");
        blueButton.id = "blue-button";
        blueButton.className = "blue-button";
        blueButton.type = "submit";

        const blueButtonText = document.createElement("span");
        blueButtonText.id = "blue-button-text";
        blueButtonText.className = "blue-button-text";
        blueButtonText.textContent = "Commencer";
    
        const formProgress = document.createElement("form")
        formProgress.id = "progress-task-form"
        formProgress.action = `/super-reminder/task/ap/${data[i].id}`
        formProgress.appendChild(blueButton);
        formProgress.appendChild(blueButtonText);

        formProgress.addEventListener('submit', async (event) => {
          event.preventDefault();
          
            clearErrors(); // On vide la div qui affiche les messages
          
            try { 
                const response = await fetch(`http://localhost/super-reminder/task/ap/${data[i].id}`, {
                  method: 'POST',
                  body: new FormData(formProgress)
                });
                if (!response.ok) {
                  throw new Error('Network response was not OK');
                }
                  const data2 = await response.json();
                if (data2) {
                  addTaskMessage.style.color = 'green'
                  ulTodo.innerHTML = '';
                  ulProgress.innerHTML = '';
                  ulDone.innerHTML = ''
                  loadDoneTasks()
                  loadProgressTasks()
                  loadToDoTasks()
                } else {
                  addTaskMessage.style.color = 'red';
                }
                }    
                catch (error) {
                  console.error('Error:', error);
                  addTaskMessage.textContent = 'Erreur survenue côté serveur.';
                }
        })
        

        blockButtonsDiv.appendChild(formProgress);
    
        const greenButton = document.createElement("button");
        greenButton.id = "green-button";
        greenButton.className = "green-button";
        greenButton.type = "submit";
    
        const greenButtonText = document.createElement("span");
        greenButtonText.id = "green-button-text";
        greenButtonText.className = "green-button-text";
        greenButtonText.textContent = "Terminer";
    
        const formDone = document.createElement("form")
        formDone.id = "done-task-form"
        formDone.action = `/super-reminder/task/ad/${data[i].id}`
        formDone.appendChild(greenButton);
        formDone.appendChild(greenButtonText);

        formDone.addEventListener('submit', async (event) => {
          event.preventDefault();
          
            clearErrors(); // On vide la div qui affiche les messages
          
            try { 
                const response = await fetch(`http://localhost/super-reminder/task/ad/${data[i].id}`, {
                  method: 'POST',
                  body: new FormData(formDone)
                });
                if (!response.ok) {
                  throw new Error('Network response was not OK');
                }
                  const data2 = await response.json();
                if (data2) {
                  addTaskMessage.style.color = 'green'
                  ulTodo.innerHTML = '';
                  ulProgress.innerHTML = '';
                  ulDone.innerHTML = ''
                  loadDoneTasks()
                  loadProgressTasks()
                  loadToDoTasks()
                } else {
                  addTaskMessage.style.color = 'red';
                }
                }    
                catch (error) {
                  console.error('Error:', error);
                }
        })

        blockButtonsDiv.appendChild(formDone);
    
        const redButton = document.createElement("button");
        redButton.id = "red-button";
        redButton.className = "red-button";
        redButton.type = "submit";
    
        const redButtonText = document.createElement("span");
        redButtonText.id = "red-button-text";
        redButtonText.className = "red-button-text";
        redButtonText.textContent = "Supprimer";
        
        const formDelete = document.createElement("form")
        formDelete.action = `/super-reminder/task/d/${data[i].id}`
        formDelete.id = "delete-task-form"
        formDelete.appendChild(redButton);
        formDelete.appendChild(redButtonText);

        formDelete.addEventListener('submit', async (event) => {
          event.preventDefault();
          
            clearErrors(); // On vide la div qui affiche les messages
          
            try { 
                const response = await fetch(`http://localhost/super-reminder/task/d/${data[i].id}`, {
                  method: 'POST',
                  body: new FormData(formDelete)
                });
                if (!response.ok) {
                  throw new Error('Network response was not OK');
                }
                  const data2 = await response.json();
                if (data2) {
                  addTaskMessage.style.color = 'green'
                  ulTodo.innerHTML = '';
                  ulProgress.innerHTML = '';
                  ulDone.innerHTML = ''
                  loadDoneTasks()
                  loadProgressTasks()
                  loadToDoTasks()
                } else {
                  addTaskMessage.style.color = 'red';
                }
                  addTaskMessage.textContent = message;
                }    
                catch (error) {
                  console.error('Error:', error);
                }
        })

        blockButtonsDiv.appendChild(formDelete);
    
        const lineDiv = document.createElement("div");
        lineDiv.id = "line";
    
        // On réecrit le HTML avec le titre, la desc et les boutons
        li.appendChild(titlePara);
        li.appendChild(descriptionSpan);
        li.appendChild(blockButtonsDiv);
        li.appendChild(lineDiv);
    
        ulTodo.appendChild(li);
      }
        
    } else {
      console.log('Échec');
    }
  } catch (error) {
    console.error('Erreur:', error);
    addTaskMessage.textContent = 'Erreur survenue côté serveur.';
  }
}

// This async function fetches all the stored inprogress tasks. When done, it displays each project inside our HTML for
// each inprogress task there is. Furthermore, it also gives the possibility to use the delete and progress buttons without loading the page

async function loadProgressTasks (){ 
  try {
    const response = await fetch(`http://localhost/super-reminder/task/gpt/${idProject}`);
    if (!response.ok) {
      throw new Error('Network response was not OK');
    }
    const data = await response.json();

    if (data) {
      const ulProgress = document.getElementById("ul-progress");
    
      for (let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        li.id = "progress-list";
    
        const titlePara = document.createElement("p");
        titlePara.id = "task-title-p-progress";
        titlePara.textContent = data[i].title;
    
        const descriptionSpan = document.createElement("span");
        descriptionSpan.id = "task-description-span-progress";
        descriptionSpan.textContent = data[i].description;
    
        // Create the buttons and line elements
        const blockButtonsDiv = document.createElement("div");
        blockButtonsDiv.id = "block-buttons-progress";

        const greenButton = document.createElement("button");
        greenButton.id = "green-button-2";
        greenButton.className = "green-button-2";
        greenButton.type = "submit";
    
        const greenButtonText = document.createElement("span");
        greenButtonText.id = "green-button-text-2";
        greenButtonText.className = "green-button-text-2";
        greenButtonText.textContent = "Terminer";
    
        const formDone = document.createElement("form")
        formDone.action = `/super-reminder/task/ad/${data[i].id}`
        formDone.id = "done-task-form"
        formDone.appendChild(greenButton);
        formDone.appendChild(greenButtonText);

        formDone.addEventListener('submit', async (event) => {
          event.preventDefault();
          
            clearErrors(); // On vide la div qui affiche les messages
          
            try { 
                const response = await fetch(`http://localhost/super-reminder/task/ad/${data[i].id}`, {
                  method: 'POST',
                  body: new FormData(formDone)
                });
                if (!response.ok) {
                  throw new Error('Network response was not OK');
                }
                  const data2 = await response.json();
                if (data2) {
                  addTaskMessage.style.color = 'green'
                  ulTodo.innerHTML = '';
                  ulProgress.innerHTML = '';
                  ulDone.innerHTML = ''
                  loadDoneTasks()
                  loadProgressTasks()
                  loadToDoTasks()
                } else {
                  addTaskMessage.style.color = 'red';
                }
                }    
                catch (error) {
                  console.error('Error:', error);
                }
        })

        blockButtonsDiv.appendChild(formDone);
    
        const redButton = document.createElement("button");
        redButton.id = "red-button-2";
        redButton.className = "red-button-2";
        redButton.type = "submit";
    
        const redButtonText = document.createElement("span");
        redButtonText.id = "red-button-text-2";
        redButtonText.className = "red-button-text-2";
        redButtonText.textContent = "Supprimer";
        
        const formDelete = document.createElement("form")
        formDelete.action = `/super-reminder/task/d/${data[i].id}`
        formDelete.id = "delete-task-form"
        formDelete.appendChild(redButton);
        formDelete.appendChild(redButtonText);

        formDelete.addEventListener('submit', async (event) => {
          event.preventDefault();
          
            clearErrors(); // On vide la div qui affiche les messages
          
            try { 
                const response = await fetch(`http://localhost/super-reminder/task/d/${data[i].id}`, {
                  method: 'POST',
                  body: new FormData(formDelete)
                });
                if (!response.ok) {
                  throw new Error('Network response was not OK');
                }
                  const data2 = await response.json();
                if (data2) {
                  addTaskMessage.style.color = 'green'
                  ulTodo.innerHTML = '';
                  ulProgress.innerHTML = '';
                  ulDone.innerHTML = ''
                  loadDoneTasks()
                  loadProgressTasks()
                  loadToDoTasks()
                } else {
                  addTaskMessage.style.color = 'red';
                }
                }    
                catch (error) {
                  console.error('Error:', error);
                }
        })

        blockButtonsDiv.appendChild(formDelete);
    
        const lineDiv = document.createElement("div");
        lineDiv.id = "line";
    
        // On réecrit le HTML avec le titre, la desc et les boutons
        li.appendChild(titlePara);
        li.appendChild(descriptionSpan);
        li.appendChild(blockButtonsDiv);
        li.appendChild(lineDiv);
    
        ulProgress.appendChild(li);
      }  
    } else {
      console.log('echec')
    }
  }    
    catch (error) {
      console.error('Error:', error);
      addTaskMessage.textContent = 'Erreur survenue côté serveur.';
    }
}

// This async function fetches all the stored done tasks. When done, it displays each project inside our HTML for
// each done task there is. Furthermore, it also gives the possibility to use the delete button without loading the page

async function loadDoneTasks (){ 
  try { 
    const response = await fetch(`http://localhost/super-reminder/task/gdt/${idProject}`, {
  });
    if (!response.ok) {
      throw new Error('Network response was not OK');
    }
      const data = await response.json();
    if (data) {
      const ulDone = document.getElementById("ul-done");
    
      for (let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        li.id = "done-list";
    
        const titlePara = document.createElement("p");
        titlePara.id = "task-title-p-done";
        titlePara.textContent = data[i].title;
    
        const descriptionSpan = document.createElement("span");
        descriptionSpan.id = "task-description-span-done";
        descriptionSpan.textContent = data[i].description;
    
        // Create the buttons and line elements
        const blockButtonsDiv = document.createElement("div");
        blockButtonsDiv.id = "block-buttons-done";

        const redButton = document.createElement("button");
        redButton.id = "red-button-3";
        redButton.className = "red-button-3";
        redButton.type = "submit";
    
        const redButtonText = document.createElement("span");
        redButtonText.id = "red-button-text-3";
        redButtonText.className = "red-button-text-3";
        redButtonText.textContent = "Supprimer";
        
        const formDelete = document.createElement("form")
        formDelete.action = `/super-reminder/task/d/${data[i].id}`
        formDelete.id = "delete-task-form"
        formDelete.appendChild(redButton);
        formDelete.appendChild(redButtonText);

        formDelete.addEventListener('submit', async (event) => {
          event.preventDefault();
          
            clearErrors(); // On vide la div qui affiche les messages
          
            try { 
                const response = await fetch(`http://localhost/super-reminder/task/d/${data[i].id}`, {
                  method: 'POST',
                  body: new FormData(formDelete)
                });
                if (!response.ok) {
                  throw new Error('Network response was not OK');
                }
                  const data2 = await response.json();
                if (data2) {
                  addTaskMessage.style.color = 'green'
                  ulTodo.innerHTML = '';
                  ulProgress.innerHTML = '';
                  ulDone.innerHTML = ''
                  loadDoneTasks()
                  loadProgressTasks()
                  loadToDoTasks()
                } else {
                  addTaskMessage.style.color = 'red';
                }
                }    
                catch (error) {
                  console.error('Error:', error);
                }
        })
        

        blockButtonsDiv.appendChild(formDelete);
    
        const lineDiv = document.createElement("div");
        lineDiv.id = "line";
    
        // On réecrit le HTML avec le titre, la desc et les boutons
        li.appendChild(titlePara);
        li.appendChild(descriptionSpan);
        li.appendChild(blockButtonsDiv);
        li.appendChild(lineDiv);
    
        ulDone.appendChild(li);
      }
    } else {
      console.log('echec')
    }
  }    
    catch (error) {
      console.error('Error:', error);
      addTaskMessage.textContent = 'Erreur survenue côté serveur.';
    }
}

loadToDoTasks();
loadProgressTasks();
loadDoneTasks();

addTaskForm.addEventListener('submit', async (event) => {
  event.preventDefault();

  clearErrors(); // On vide la div qui affiche les messages

  if (!validateFields()) { // Si les champs sont remplis on effectue le fetch
    return;
  }

  try { 
      const response = await fetch('http://localhost/super-reminder/task/ta', {
        method: 'POST',
        body: new FormData(addTaskForm)
      });
      if (!response.ok) {
        throw new Error('Network response was not OK');
      }
        const data = await response.json();
        const message = data.message;
      if (data.success) {
        addTaskMessage.style.color = 'green'
        ulTodo.innerHTML = '';
        loadToDoTasks()
      } else {
        addTaskMessage.style.color = 'red';
      }
        addTaskMessage.textContent = message;
      }    
      catch (error) {
        console.error('Error:', error);
        addTaskMessage.textContent = 'Erreur survenue côté serveur.';
      }
  });

// Clearing the message 

function clearErrors() {
addTaskMessage.textContent = '';
}

// Function that validates add task fields

function validateFields() {
const titleValue = document.getElementById('task-title').value.trim();
const descriptionValue = document.getElementById('task-description').value.trim();

if (titleValue === '' && descriptionValue === '') {
  addTaskMessage.textContent = 'Les champs doivent être remplis';
  return false;
} else {
  addTaskMessage.textContent = '';
  return true;
}
}
