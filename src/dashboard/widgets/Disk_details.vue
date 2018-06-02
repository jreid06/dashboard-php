<template lang="html">
    <div :class="'col-12 col-lg-'+columns">
        <ul class="list-group">
            <li class="list-group-item list-group-item-light d-flex justify-content-between align-items-center ">
                Disk Information
            </li>

            <li class="list-group-item list-group-item-light" v-for="(stat, index) in stats">
                <i>{{stat.title}} - <span class="font-weight-bold">{{stat.readable_size}}</span> </i>
                <hr>
                <div class="progress">
                  <div class="progress-bar" role="progressbar" :style="'width: '+stat.percent+'%'" :aria-valuenow="stat.percent" aria-valuemin="0" aria-valuemax="100">{{stat.percent}}%</div>
                </div>
            </li>
        </ul>

    </div>
</template>

<script>
export default {
	props: {
		columns: {
			type: Number,
			required: true
		}
	},
	data: function() {
		return {
			stats: [
				{
					id: 'total_space',
					title: "Total disk space",
					readable_size: '',
					bytes: 0,
					percent: 100
				},
				{
					id: 'used_space',
					title: "Used disk space",
					readable_size: '',
					bytes: 0,
					percent: 0
				},
				{
					id: 'free_space',
					title: "Free disk space",
					readable_size: '',
					bytes: 0,
					percent: 0
				}
			]
		}
	},
	watch: {
		'$route': function(val) {
			console.log('route changed. update disk details');
		}
	},
	methods: {
		getDirectoryDetails() {
			let free_space_percentage = '',
				used_space_percentage = '',
				vm = this;

			setTimeout(function() {
				$.ajax({
					url: '/backend/controller/stats.php',
					type: 'get',
					data: {
						stat_type: 'directory info'
					},
					success(data) {
						let $data = JSON.parse(data),
							raw_data = $data.info.data.raw_data;
						console.log($data);


						// TODO: turn calculate percentage into a function
						free_space_percentage = ((raw_data.raw_total_space - raw_data.raw_used_space) / raw_data.raw_total_space) * 100;

						used_space_percentage = ((raw_data.raw_total_space - raw_data.raw_free_space) / raw_data.raw_total_space) * 100;

						// TODO: make this into a function for easier reading
						// assign data to vm
						vm.stats[0].readable_size = $data.info.data.disk_total_space;
						vm.stats[0].bytes = raw_data.raw_total_space;

						vm.stats[1].percent = used_space_percentage.toFixed(2);
						vm.stats[1].readable_size = $data.info.data.disk_used_space;
						vm.stats[1].bytes = raw_data.raw_used_space;

						vm.stats[2].percent = free_space_percentage.toFixed(2);
						vm.stats[2].readable_size = $data.info.data.disk_free_space;
						vm.stats[2].bytes = raw_data.raw_free_space;



					},
					error() {

					}
				})
			}, 800);

		}
	},
	mounted() {
		this.getDirectoryDetails();
	}
}
</script>

<style lang="scss" scoped>
.badge {
    flex: 0 !important;
}

.progress-bar {
    transition: all 0.6s ease-in-out;
    padding: 5px;
}
</style>
