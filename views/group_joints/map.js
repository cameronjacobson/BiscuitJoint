function (doc) {
	if (doc.class == 'BiscuitJoint\\JointDefinition') {
		if(doc.state.partA && doc.state.partB && doc.state.type){
			emit([doc.state.partA, doc.state.type], {_id:doc._id});
			if(doc.state.symmetric){
				emit([doc.state.partB, doc.state.type], {_id:doc._id});
			}
		}
	}
}
