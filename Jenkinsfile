pipeline {
  environment {
    dockerappimagename = "arunvarghe/meetup"
    dockerappcontainername = 'meetup-app'
    dockerAppImage = ""
    dockernginximagename = "arunvarghe/nginx"
    dockerNginxImage = ""
  }
  agent any
  stages {
    stage('Checkout Source') {
      steps {
        git 'https://github.com/arunvarghe/meetup.git'
      }
    }

    stage('Build image') {
      steps{
        script {
            dockerAppImage = docker.build(dockerappimagename, '-f ./docker/prod/Dockerfile .')
        }
      }
    }
    stage('Run install libraries and tests') {
      steps{
        script {
            dockerAppImage.run("--name ${dockerappcontainername} --volume ${pwd()}/:/code")
            sh "docker exec ${dockerappcontainername} make install"
            try {
                // run tests in the same workspace that the project was built
                sh "docker exec ${dockerappcontainername} make test"
            } catch (e) {
                // if any exception occurs, mark the build as failed
                currentBuild.result = 'FAILURE'
                throw e
            }
            sh "ls -la"
        }
      }
    }
    stage('Build image again with vendor and node modules to make complete pack') {
      steps{
        script {
            sh "docker rm -f ${dockerappcontainername}"
            sh "docker rmi ${dockerappimagename}"
            dockerAppImage = docker.build(dockerappimagename, '-f ./docker/prod/Dockerfile .')
        }
      }
    }
    stage('Build NGINX image') {
      steps{
        script {
            dockerNginxImage = docker.build(dockernginximagename, '-f ./docker/prod/nginx/Dockerfile .')
        }
      }
    }
    stage('Pushing NGINX Image') {
      environment {
        registryCredential = 'dockerhub-credentials'
      }
      steps{
        script {
          docker.withRegistry( 'https://registry.hub.docker.com', registryCredential ) {
            dockerNginxImage.push("latest")
          }
        }
      }
    }
    stage('Pushing App Image') {
      environment {
        registryCredential = 'dockerhub-credentials'
      }
      steps{
        script {
          docker.withRegistry( 'https://registry.hub.docker.com', registryCredential ) {
            dockerAppImage.push("latest")
          }
        }
      }
    }
    stage('Clean image') {
      steps{
        script {
            sh "docker rmi ${dockernginximagename}"
            sh "docker rmi ${dockerappimagename}"
        }
      }
    }
    stage('Deploying app container to Kubernetes') {
      steps {
        script {
          kubernetesDeploy(configs: "kubernetes/app.yaml", kubeconfigId: "kubernetes")
          kubernetesDeploy(configs: "kubernetes/nginx.yaml", kubeconfigId: "kubernetes")
        }
      }
    }
  }
}