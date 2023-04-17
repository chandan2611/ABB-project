const update = document.querySelector('input[type="submit"]')
var status
update.addEventListener('click', () => {
    //http://localhost:5501/Model.php?firtName=qqq&lastName=qqq&....
    const formData= new URLSearchParams(new FormData(document.querySelector('form')))
    fetch('http://localhost:3306/Model.php', {
        method: 'PATCH',
        body: formData,
        credentials: 'include'
        })
        .then(res => {
            Status = res.status
            return res.text()
        })
        .then(data => {
            alert(data)
            if (Status == 200)
            location.href= "./index.html"
    
        })
        .catch(err => {alert(err) })
})