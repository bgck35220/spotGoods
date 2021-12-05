
    //user-update 帳號切換valid值
    function userSwitch(){
        let btnOpen=document.querySelector("#btn-open")
        let btnClose=document.querySelector("#btn-close")

        let validswich =document.querySelector("#validswich")
        let validNum=0

        btnOpen.addEventListener("click",e=>{
        btnOpen.classList.toggle("d-none");
        btnClose.classList.toggle("d-none");
        if(e.target.textContent ==="啟用"){
            validNum = 1
        }else{
            validNum = 0
        }
        validswich.value=validNum;
    })

    btnClose.addEventListener("click",e=>{
        btnClose.classList.toggle("d-none");
        btnOpen.classList.toggle("d-none");

        if(e.target.textContent === "停用"){
            validNum=0
        }else{
            validNum=1
        }
        validswich.value=validNum;
    })
    }
    userSwitch()


