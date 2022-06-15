<template>
    <div class="container">
        <div class="col-md-12">

            <h1 class="text-center">Vidobu Person List</h1>
            <div class="pb-3" align="right">
                <button class="btn btn-primary" @click="addPerson">Ekle</button>
            </div>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Post Code</th>
                    <th>City</th>
                    <th>Country</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="person in people">
                    <td>{{ person.name }}</td>
                    <td>{{ person.birthday }}</td>
                    <td>{{ person.gender }}</td>
                    <td>{{ person.address }}</td>
                    <td>{{ person.post_code }}</td>
                    <td>{{ person.city_name }}</td>
                    <td>{{ person.country_name }}</td>
                    <td width="70" class="text-center"><a href="javascript:void(0)" @click="editPerson" id="editCompany"
                                                          data-toggle="modal"
                                                          data-target='#exampleModal' :id="person.id"
                    ><i :id="person.id"
                        class="fa fa-pencil-square-o px-1"></i></a>

                        <a href="javascript:void(0)"><i :id="person.id"
                                                        @click="removePerson" class="fa fa-trash-o px-1"></i></a>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Post Code</th>
                    <th>City</th>
                    <th>Country</th>
                    <th></th>
                </tr>
                </tfoot>

            </table>
        </div>

        <b-modal ref="modal-edit" id="modal-edit" hide-footer hide-header>
            <h1>Person</h1>
            <div class="d-block">
                <FormulateForm
                    @submit="updatePerson()"
                >
                <div class="form-group pt-1">
                    <FormulateInput
                        name="name"
                        type="text"
                        label="Name"
                        validation="required"
                        v-model="edit.name"
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="birthday"
                        error-behavior="live"
                        type="date"
                        max="2022-01-01"
                        label="Birthday"
                        validation="required"
                        v-model="edit.birthday"
                    />
                </div>
                <div class="form-group pt-1">

                    <FormulateInput
                        name="gender"
                        :options="{Male: 'Male', Female: 'Female'}"
                        type="select"
                        placeholder="Select gender"
                        label="Gender"
                        validation="required"
                        v-model="edit.gender"
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="address"
                        type="text"
                        label="Address"
                        validation="required"
                        v-model="edit.address"
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="post_code"
                        type="text"
                        label="Post Code"
                        validation="required"
                        v-model="edit.post_code"
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="city_name"
                        type="text"
                        label="City"
                        validation="required"
                        v-model="edit.city_name"
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="country_name"
                        type="text"
                        label="Country"
                        validation="required"
                        v-model="edit.country_name"
                    />
                </div>
                <div class="form-group pt-3">
                    <button type="submit" class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-secondary" @click="hideModal">Cancel</button>
                </div>
                </FormulateForm>
            </div>
        </b-modal>

        <b-modal ref="modal-create" id="modal-create" hide-footer hide-header>
            <h1>Person</h1>
            <div class="d-block">
                <FormulateForm
                    @submit="createPerson()"
                    v-model="create"
                >
                    <div class="form-group pt-1">
                        <FormulateInput
                            name="name"
                            type="text"
                            label="Name"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-1">
                        <FormulateInput
                            name="birthday"
                            type="date"
                            max="2022-01-01"
                            label="Birthday"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-1">

                        <FormulateInput
                            name="gender"
                            :options="{Male: 'Male', Female: 'Female'}"
                            type="select"
                            placeholder="Select gender"
                            label="Gender"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-1">
                        <FormulateInput
                            name="address"
                            type="text"
                            label="Address"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-1">
                        <FormulateInput
                            name="post_code"
                            type="text"
                            label="Post Code"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-1">
                        <FormulateInput
                            name="city_name"
                            type="text"
                            label="City"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-1">
                        <FormulateInput
                            name="country_name"
                            type="text"
                            label="Country"
                            validation="required"
                        />
                    </div>
                    <div class="form-group pt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" @click="hideModal">Cancel</button>
                    </div>
                </FormulateForm>
            </div>
        </b-modal>

        <b-modal ref="modal-delete" id="modal-delete" hide-footer hide-header>
            <h5>Are you sure you want to delete this person?</h5>
            <div class="d-block">
                <div class="form-group pt-1">
                    <FormulateInput
                        name="name"
                        type="text"
                        label="Name"
                        validation="required"
                        v-model="edit.name"
                        disabled
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="birthday"
                        error-behavior="live"
                        type="date"
                        label="Birthday"
                        validation="required"
                        v-model="edit.birthday"
                        disabled
                    />
                </div>
                <div class="form-group pt-1">

                    <FormulateInput
                        name="gender"
                        :options="{Male: 'Male', Female: 'Female'}"
                        type="select"
                        placeholder="Select gender"
                        label="Gender"
                        validation="required"
                        v-model="edit.gender"
                        disabled
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="address"
                        type="text"
                        label="Address"
                        validation="required"
                        v-model="edit.address"
                        disabled
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="post_code"
                        type="text"
                        label="Post Code"
                        validation="required"
                        v-model="edit.post_code"
                        disabled
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="city_name"
                        type="text"
                        label="City"
                        validation="required"
                        v-model="edit.city_name"
                        disabled
                    />
                </div>
                <div class="form-group pt-1">
                    <FormulateInput
                        name="country_name"
                        type="text"
                        label="Country"
                        validation="required"
                        v-model="edit.country_name"
                        disabled
                    />
                </div>
                <div class="form-group pt-3">
                    <button type="submit" class="btn btn-success" @click="deletePerson">OK</button>
                    <button type="button" class="btn btn-danger" @click="hideModal">Cancel</button>
                </div>
            </div>
        </b-modal>

    </div>

</template>
<script>

export default {
    data() {
        return {
            people: [],
            person: {
                id: '',
                name: '',
                birthday: '',
                gender: '',
                address: '',
                post_code: '',
                city_name: '',
                country_name: ''
            },
            create: {
                id: '',
                name: '',
                birthday: '',
                gender: '',
                address: '',
                post_code: '',
                city_name: '',
                country_name: ''
            },
            edit: {
                id: '',
                name: '',
                birthday: '',
                gender: '',
                address: '',
                post_code: '',
                city_name: '',
                country_name: ''
            }
        }
    },

    created() {
        this.fetchPeople();
    },

    methods: {

        hideModal() {
            window.location.reload();
        },

        fetchPeople() {
            fetch('/api/person')
                .then(res => res.json())
                .then(res => {
                    this.people = res.data;
                })
                .catch(err => console.log(err));
        },
        addPerson() {
            this.create = {
                id: '',
                name: '',
                birthday: '',
                gender: '',
                address: '',
                post_code: '',
                city_name: '',
                country_name: ''
            }
            this.$refs['modal-create'].show();
        },

        editPerson($event) {
            var people = this.people
            var personId = $event.target.id
            var person = people.find(e => e.id == personId);
            this.edit = person
            this.$refs['modal-edit'].show();
        },
        removePerson($event) {
            var people = this.people
            var personId = $event.target.id
            var person = people.find(e => e.id == personId);
            this.edit = person
            this.$refs['modal-delete'].show();
        },

        deletePerson($event) {
            fetch("api/person/" + this.edit.id, {method: 'DELETE'})
                .then(response => {
                    if (response.status === 200) {
                        this.hideModal()
                    }
                })
        },
        updatePerson() {
            const requestOptions = {
                method: "PATCH",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(this.edit)
            };
            fetch("api/person/" + this.edit.id, requestOptions)
                .then(response => {
                    if (response.status === 200) {
                        this.hideModal()
                    }
                })

        },
        createPerson() {
            const requestOptions = {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify(this.create)
            };
            fetch("api/person", requestOptions)
                .then(response => {
                    if (response.status === 200) {
                        this.hideModal()
                    }
                })
        }
    }
}
</script>

