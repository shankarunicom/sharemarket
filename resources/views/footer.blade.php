<script>
const supported = ('contacts' in navigator && 'ContactsManager' in window);
const props = ['name', 'email', 'tel', 'address', 'icon'];
const opts = {multiple: true};

function getcontact(){
    
    try {
    const contacts = await navigator.contacts.select(props, opts);
    handleResults(contacts);
        console.log(contacts);
    } catch (ex) {
        console.log(ex);
    }
}

</script>


</body>
</html>