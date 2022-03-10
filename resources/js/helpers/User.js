import router from '../routes/routes.js'

class User {

    storeUser(user) {
        localStorage.setItem('user', user);
    }

    getUser() {
        return JSON.parse(localStorage.getItem('user'));
    }

    isLogged() {
        return this.getUser() !== null ? this.getUser() : false;
    }

    logout() {
        localStorage.removeItem('user');
        router.push({ name: 'home' })

    }
    checkUel($url) {
        axios.get($url).then((response) => {
        }).catch((error) => {
            if (error.response.status !== 200 ) {
                router.push({ name: 'home' })

                const swalWithBootstrapButtons = Swal.mixin({})

                swalWithBootstrapButtons.fire({
                    title: 'Page Not Found ...',
                    icon: 'warning',
                    showCancelButton: false,
                    reverseButtons: false,
                    showConfirmButton: false,
                    timer: 2500

                })
            } else {

            }
        })
    }
    isAdmin(){
        if(getUser().admin == 0){
            router.push({ name: 'home' })

            const swalWithBootstrapButtons = Swal.mixin({})

            swalWithBootstrapButtons.fire({
                title: 'Page Not Found ...',
                icon: 'warning',
                showCancelButton: false,
                reverseButtons: false,
                showConfirmButton: false,
                timer: 2500

            })
        }
    }


}

export default User = new User();
