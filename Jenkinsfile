pipeline {
  environment {
    dockerappimagename = "arunvarghe/meetup"
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
            dockerAppImage.inside {
                sh 'make install'
                sh 'make test'
            }
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
          docker.withRegistry( 'https://hub.docker.com', registryCredential ) {
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
          docker.withRegistry( 'https://hub.docker.com', registryCredential ) {
            dockerAppImage.push("latest")
          }
        }
      }
    }
//     stage('Deploying React.js container to Kubernetes') {
//       steps {
//         script {
//           kubernetesDeploy(configs: "deployment.yaml", "service.yaml")
//         }
//       }
//     }
  }
}