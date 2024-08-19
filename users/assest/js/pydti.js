function crearEditor(idContenedor, boxinterno){
    const containerDiv = document.createElement("div");
    containerDiv.classList.add("contenedor_box");

    const optionsDiv = document.createElement("div");
    optionsDiv.classList.add("options");
    containerDiv.appendChild(optionsDiv);
   
    // Text format
    const boldBtn = document.createElement("button");
    boldBtn.classList.add('buttonxp')
    boldBtn.setAttribute("name", "bold");
    boldBtn.classList.add("option-btn", "format");
    const boldIcon = document.createElement("i");
    boldIcon.classList.add("fa-solid", "fa-bold");
    boldBtn.appendChild(boldIcon);
    optionsDiv.appendChild(boldBtn);

    const italicBtn = document.createElement("button");
    italicBtn.classList.add('buttonxp')
    italicBtn.setAttribute("name", "italic");
    italicBtn.classList.add("option-btn", "format");
    const italicIcon = document.createElement("i");
    italicIcon.classList.add("fa-solid", "fa-italic");
    italicBtn.appendChild(italicIcon);
    optionsDiv.appendChild(italicBtn);

    const underlineBtn = document.createElement("button");
    underlineBtn.classList.add('buttonxp')
    underlineBtn.setAttribute("name", "underline");
    underlineBtn.classList.add("option-btn", "format");
    const underlineIcon = document.createElement("i");
    underlineIcon.classList.add("fa-solid", "fa-underline");
    underlineBtn.appendChild(underlineIcon);
    optionsDiv.appendChild(underlineBtn);

    // Add alignment buttons to optionsDiv
    const justifyLeftBtn = document.createElement("button");
    justifyLeftBtn.classList.add('buttonxp')
    justifyLeftBtn.setAttribute("name", "justifyLeft");
    justifyLeftBtn.id = "justifyLeft";
    justifyLeftBtn.classList.add("option-btn", "align");
    justifyLeftBtn.innerHTML = '<i class="fa-solid fa-align-left"></i>';
    optionsDiv.appendChild(justifyLeftBtn);

    const justifyCenterBtn = document.createElement("button");
    justifyCenterBtn.classList.add('buttonxp')
    justifyCenterBtn.setAttribute("name", "justifyCenter");
    justifyCenterBtn.id = "justifyCenter";
    justifyCenterBtn.classList.add("option-btn", "align");
    justifyCenterBtn.innerHTML = '<i class="fa-solid fa-align-center"></i>';
    optionsDiv.appendChild(justifyCenterBtn);

    const justifyRightBtn = document.createElement("button");
    justifyRightBtn.classList.add('buttonxp')
    justifyRightBtn.setAttribute("name", "justifyRight");
    justifyRightBtn.id = "justifyRight";
    justifyRightBtn.classList.add("option-btn", "align");
    justifyRightBtn.innerHTML = '<i class="fa-solid fa-align-right"></i>';
    optionsDiv.appendChild(justifyRightBtn);

    const justifyFullBtn = document.createElement("button");
    justifyFullBtn.classList.add('buttonxp')
    justifyFullBtn.setAttribute("name", "justifyFull");
    justifyFullBtn.id = "justifyFull";
    justifyFullBtn.classList.add("option-btn", "align");
    justifyFullBtn.innerHTML = '<i class="fa-solid fa-align-justify"></i>';
    optionsDiv.appendChild(justifyFullBtn);

    // List
    const insertOrderedListBtn = document.createElement("button");
    insertOrderedListBtn.classList.add('buttonxp')
    insertOrderedListBtn.setAttribute("name", "insertOrderedList");
    insertOrderedListBtn.classList.add("option-btn");
    const insertOrderedListIcon = document.createElement("div");
    insertOrderedListIcon.classList.add("fa-solid", "fa-list-ol");
    insertOrderedListBtn.appendChild(insertOrderedListIcon);
    optionsDiv.appendChild(insertOrderedListBtn);

    const insertUnOrderedListBtn = document.createElement("button");
    insertUnOrderedListBtn.classList.add('buttonxp')
    insertUnOrderedListBtn.setAttribute("name", "insertUnOrderedList");
    insertUnOrderedListBtn.classList.add("option-btn");
    const insertUnOrderedListIcon = document.createElement("div");
    insertUnOrderedListIcon.classList.add("fa-solid", "fa-list");
    insertUnOrderedListBtn.appendChild(insertUnOrderedListIcon);
    optionsDiv.appendChild(insertUnOrderedListBtn);

    // Undo/Redo
    const undoBtn = document.createElement("button");
    undoBtn.classList.add('buttonxp')
    undoBtn.setAttribute("name", "undo");
    undoBtn.classList.add("option-btn");
    const undoIcon = document.createElement("i");
    undoIcon.classList.add("fa-solid", "fa-rotate-left");
    undoBtn.appendChild(undoIcon);
    optionsDiv.appendChild(undoBtn);

    const redoBtn = document.createElement("button");
    redoBtn.classList.add('buttonxp')
    redoBtn.setAttribute("name", "redo");
    redoBtn.classList.add("option-btn");
    const redoIcon = document.createElement("i");
    redoIcon.classList.add("fa-solid", "fa-rotate-right");
    redoBtn.appendChild(redoIcon);
    optionsDiv.appendChild(redoBtn);

    // Link
    const createLinkBtn = document.createElement("button");
    createLinkBtn.classList.add('buttonxp')
    createLinkBtn.setAttribute("name", "createLink");
    createLinkBtn.setAttribute("id", "createLink");
    createLinkBtn.classList.add("option-btn");
    const createLinkIcon = document.createElement("i");
    createLinkIcon.classList.add("fa-solid", "fa-link");
    createLinkBtn.appendChild(createLinkIcon);
    optionsDiv.appendChild(createLinkBtn);

    const unLinkBtn = document.createElement("button");
    unLinkBtn.classList.add('buttonxp')
    unLinkBtn.setAttribute("name", "unLink");
    unLinkBtn.classList.add("option-btn");
    const unLinkIcon = document.createElement("i");
    unLinkIcon.classList.add("fa-solid", "fa-unlink");
    unLinkBtn.appendChild(unLinkIcon);
    optionsDiv.appendChild(unLinkBtn);

    // Add spacing buttons to optionsDiv
    const indentBtn = document.createElement("button");
    indentBtn.classList.add('buttonxp')
    indentBtn.setAttribute("name", "indent");
    indentBtn.id = "indent";
    indentBtn.classList.add("option-btn", "spacing");
    indentBtn.innerHTML = '<i class="fa-solid fa-indent"></i>';
    optionsDiv.appendChild(indentBtn);

    const outdentBtn = document.createElement("button");
    outdentBtn.classList.add('buttonxp')
    outdentBtn.setAttribute("name", "outdent");
    outdentBtn.id = "outdent";
    outdentBtn.classList.add("option-btn", "spacing");
    outdentBtn.innerHTML = '<i class="fa-solid fa-outdent"></i>';
    optionsDiv.appendChild(outdentBtn);

    // Add headings dropdown to optionsDiv
    const formatBlockSelect = document.createElement("select");
    formatBlockSelect.id = "formatBlock";
    formatBlockSelect.setAttribute("name", "formatBlock");
    formatBlockSelect.classList.add("adv-option-button");
    const headings = ["H1", "H2", "H3", "H4", "H5", "H6"];
    for (let i = 0; i < headings.length; i++) {
    const option = document.createElement("option");
    option.value = headings[i];
    option.text = headings[i];
    formatBlockSelect.appendChild(option);
    }
    optionsDiv.appendChild(formatBlockSelect);


    const editable = document.createElement('div');
    editable.classList.add('boxcontent')
    editable.id = boxinterno;
    editable.name = boxinterno;
    editable.setAttribute('contenteditable', 'true');
    containerDiv.appendChild(editable);
    
    const editorDiv = document.getElementById(idContenedor);
    editorDiv.appendChild(containerDiv);
    let writingArea = document.getElementById(boxinterno);
    writingArea.classList.add('contenido');

    let optionsButtons = containerDiv.querySelectorAll(".option-btn");
    let advancedOptionButtom = document.querySelectorAll(".adv-option-button");
    let linkButton = document.getElementById("createLink");
    let alignButton = document.querySelectorAll(".align");
    let spacingButton = containerDiv.querySelectorAll(".spacing");
    let formatButton = containerDiv.querySelectorAll(".format");
    let scriptButton = containerDiv.querySelectorAll(".script");

   

    


    const initializer = () => {

        highlighter(alignButton, true);
        highlighter(spacingButton, true);
        highlighter(formatButton, false);
        highlighter(scriptButton, true);
    } 

    const highlighter = (className, needsRemoval) => {
        className.forEach((button) => {
            button.addEventListener("click", (e) =>{
                e.preventDefault();
                if (needsRemoval){
                    let Alreadyactivert = false;
                
    
                if(button.classList.contains("activert")){
                    Alreadyactivert = true;
                }
    
                highlighterRemover(className);
                    if(!Alreadyactivert){
                        button.classList.add("activert");
                    }
            }
            else {
    
                button.classList.toggle("activert");
    
                }
    
            });
            
        });
    };

    const highlighterRemover = (className) => {
        className.forEach((button) => {
            button.classList.remove("activert");
        })
    }

    const modifyText = (command, defaultUi, value) => {
        document.execCommand(command, defaultUi, value);
    }
    
    optionsButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
            modifyText(button.name, false, null);
            event.preventDefault();
        });
    });
    
    
    advancedOptionButtom.forEach((button)=>{
        button.addEventListener("change", (e) => {
            e.preventDefault();
            modifyText(button.id, false, button.value);
        });
    });


    linkButton.addEventListener("click", (e) =>{
        preventDefault();
        let usrLink = prompt("Ingresa una URL");
        if(/http/i.test(usrLink)){
            modifyText(linkButton.id, false, usrLink);
        } else {
            usrLink = "http://" + usrLink;
            modifyText(linkButton.id, false, usrLink);
        }
    })
    
    initializer();

}
