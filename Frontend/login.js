const login = document.querySelector('input[type="submit"]')
var status
login.addEventListener('click', () => {
    const formData= new FormData(docuemnt.querySelector('form'))
    fetch('http://localhost:3306/Model.php', {
        method: 'POST',
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