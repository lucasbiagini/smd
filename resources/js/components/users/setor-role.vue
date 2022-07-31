<template>
    <b-container>
        <b-row>
            <b-col>
                <label class="typo__label" for="multiselect-setores">Setor</label>
                <multiselect
                    v-model="selectedCountries"
                    :multiple="false"
                    id="multiselect-setores"
                    label="name"
                    track-by="code"
                    placeholder="Type to search"
                    open-direction="bottom"
                    :options="countries"
                    :searchable="true"
                    :loading="isLoading"
                    :internal-search="false"
                    :clear-on-select="false"
                    :close-on-select="true"
                    :options-limit="300"
                    :limit="3"
                    :limit-text="limitText"
                    :max-height="600"
                    :show-no-results="false"
                    :hide-selected="true"
                    @search-change="asyncFind">
                    <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
                </multiselect>
                <pre class="language-json"><code>{{ selectedCountries  }}</code></pre>
            </b-col>
            <b-col>2 of 3</b-col>
            <b-col>
                <b-button>Incluir</b-button>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import axios from 'axios'
import Multiselect from "vue-multiselect";

export default({
    components: {
        Multiselect
    },
    props: ['user_id'],
    data () {
        return {
            selectedCountries: [],
            countries: [],
            isLoading: false
        }
    },
    mounted () {

    },
    methods: {
        limitText (count) {
            return `and ${count} other countries`
        },
        asyncFind (query) {
            this.isLoading = true
            axios.post('/countries').then(response => {
                this.countries = response.data
                this.isLoading = false
            })
        },
        clearAll () {
            this.selectedCountries = []
        }
    }
})
</script>
